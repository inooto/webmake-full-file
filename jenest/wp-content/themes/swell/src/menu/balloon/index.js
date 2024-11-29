/**
 * @WordPress dependencies
 */
import domReady from '@wordpress/dom-ready';
import { useState } from '@wordpress/element';
import { addFilter } from '@wordpress/hooks';
import render from '@swell-guten/compatible/render';

/**
 * @SWELL dependencies
 */
import BalloonEdit from './edit';
import BalloonList from './list';
import BalloonMigrate from './migrate';

import { MediaUpload } from '@wordpress/media-utils';

// APIエンドポイント
export const swellApiPath = '/wp/v2/swell-balloon';

// アイコン画像プレースホルダ
export const iconPlaceholder =
	'https://0.gravatar.com/avatar/00000000000000000000000000000000?s=128&d=mp&r=g';

// Mediauploadコンポーネントを使えるようにする
addFilter(
	'editor.MediaUpload',
	'core/edit-post/components/media-upload/replace-media-upload',
	() => MediaUpload
);

const BalloonMenu = ({ isOld }) => {
	// GETパラメータの取得
	const params = {};
	location.search
		.substring(1)
		.split('&')
		.forEach((param) => {
			const [key, ...val] = param.split('=');
			if (key !== '') {
				params[key] = decodeURI(val.join('='));
			}
		});

	// 新規追加かどうか
	const isNewEdit = 'post_new' in params;

	// 編集ページID
	const [id, setId] = useState(params.id);

	// 古いデータあるかどうか
	if (isOld) {
		return <BalloonMigrate />;
	}

	// 編集ページ
	if (id || isNewEdit) {
		return <BalloonEdit {...{ id, setId }} />;
	}

	// 一覧ページ
	return <BalloonList />;
};

// 念のため、DOM読み込み待ちを追加
domReady(() => {
	const root = document.getElementById('swell_setting_page_content');
	const isOld = root.getAttribute('data-is-old');

	render(root, <BalloonMenu isOld={isOld} />);
});
