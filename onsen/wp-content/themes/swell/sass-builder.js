/* eslint no-console: 0 */
// console.log('start sass-builder.js ...');

const path = require('path');
const fs = require('fs');

// glob
const glob = require('glob');

// node-sass
const sass = require('node-sass');
const globImporter = require('node-sass-glob-importer');

// postcss
const postcss = require('postcss');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const mqpacker = require('css-mqpacker');

// consoleの色付け
const COLOR = {
	red: '\u001b[31m',
	green: '\u001b[32m',
	reset: '\x1b[0m',
};

// 環境変数・引数
const envTYPE = process.env.TYPE || '';
const TARGET_DIR = process.argv[2] || '';

// 書き出し処理
const writeCSS = (filePath, css) => {
	const dir = path.dirname(filePath);

	// ディレクトリがなければ作成
	if (!fs.existsSync(dir)) {
		console.log('mkdir ' + dir);
		fs.mkdirSync(dir, { recursive: true });
	}

	// css書き出し
	// console.log('Wrote CSS to ' + filePath);
	fs.writeFileSync(filePath, css);
};

function sassRender(srcPath, distPath) {
	return new Promise((resolve) => {
		// renderSyncだと importer 使えない
		sass.render(
			{
				file: srcPath,
				outputStyle: 'compressed',
				importer: globImporter(),
			},
			function (err, sassResult) {
				if (err) {
					console.error(COLOR.red + err);
				} else {
					const css = sassResult.css.toString();

					// postcss実行
					postcss([autoprefixer, mqpacker, cssnano])
						.process(css, { from: undefined })
						.then((postcssResult) => {
							writeCSS(distPath, postcssResult.css);
							// if (postcssResult.map) {fs.writeFile('dest/app.css.map', postcssResult.map.toString(), () => true);}

							// resolve
							resolve(COLOR.green + 'Completed.');
						});
				}
			}
		);
	});
}

(async () => {
	// パス
	let src = 'src/scss';
	let dist = 'build/css';
	const ignore = ['**/_*.scss'];
	let files = [];

	// const targets = null;
	// if ('blocks' === envTYPE) {
	// 	src = 'src/gutenberg/blocks';
	// 	dist = 'build/blocks';
	// }

	if ('main' === envTYPE) {
		files = [
			src + '/main.scss',
			src + '/blocks.scss',
			src + '/editor/gutenberg.scss',
			src + '/editor/editor_style.scss',
		];
		// ignore = ['**/_*.scss', '**/modules/**', '**/plugins/**', '**/admin/**'];
	} else {
		if ('' !== TARGET_DIR) {
			src += '/' + TARGET_DIR;
			dist += '/' + TARGET_DIR;
		}
		files = glob.sync(src + '/**/*.scss', { ignore });
	}

	for (const filePath of files) {
		console.log(COLOR.green + 'Start sassRender: ' + COLOR.reset + filePath);

		const fileName = filePath.replace(src + '/', '');
		const srcPath = path.resolve(__dirname, src, fileName);
		const distPath = path.resolve(__dirname, dist, fileName).replace('.scss', '.css');

		/* eslint no-unused-vars:0 */
		const result = await sassRender(srcPath, distPath);
		// console.log(result);
	}
})();
