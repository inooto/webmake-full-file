/**
 * @WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useEffect, useState } from '@wordpress/element';
import { Button } from '@wordpress/components';
import { addQueryArgs } from '@wordpress/url';
import { Icon, close, shortcode, stack, chevronLeft, chevronRight } from '@wordpress/icons';

/**
 * @Others dependencies
 */
import classnames from 'classnames';

export default function BalloonListItem({
	idx,
	balloonData,
	copyBalloon,
	deleteBalloon,
	swapBallons,
	isFirst,
	isLast,
}) {
	const { id, title, data } = balloonData;
	const [showCode, setShowCode] = useState(false);

	useEffect(() => {
		setShowCode(false);
	}, [id, idx]);

	// ふきだし編集リンク
	const editUrl = addQueryArgs('admin.php', {
		page: 'swell_balloon',
		id,
	});

	const balloonPreview = (
		<div className={`c-balloon -bln-${data.align}`} data-col={data.col} aria-hidden='true'>
			{data.icon && (
				<div className={`c-balloon__icon -${data.shape}`}>
					<img src={data.icon} alt='' className='c-balloon__iconImg' width='80px' />
					<span className='c-balloon__iconName'>{data.name}</span>
				</div>
			)}
			<div className={`c-balloon__body -${data.type} -border-${data.border}`}>
				<div className='c-balloon__text'>
					{__('ふきだしテキスト', 'swell')}
					<span className='c-balloon__shapes'>
						<span className='c-balloon__before'></span>
						<span className='c-balloon__after'></span>
					</span>
				</div>
			</div>
		</div>
	);

	return (
		<li
			key={idx}
			className={classnames('swl-setting-balloon__item', {
				'show-code': showCode,
			})}
			data-id={id}
		>
			{/* memo: 移動ボタンのツールチップが変なところに出現するため、<Icon />で中身を描画している。 */}
			{!isFirst && (
				<Button
					className='swl-setting-balloon__arrow -prev'
					label={__('前に移動', 'swell')}
					onClick={() => {
						swapBallons(idx, 'prev');
					}}
				>
					<Icon icon={chevronLeft} />
				</Button>
			)}
			{!isLast && (
				<Button
					className='swl-setting-balloon__arrow -next'
					label={__('次に移動', 'swell')}
					onClick={() => {
						swapBallons(idx, 'next');
					}}
				>
					<Icon icon={chevronRight} />
				</Button>
			)}
			<div key={idx} className='swl-setting-balloon__item__inner'>
				<div className='swl-setting-balloon__btns'>
					<Button
						label={__('ショートコードを表示する', 'swell')}
						className='swl-setting-balloon__shortCode swl-setting-balloon__btn'
						icon={showCode ? close : shortcode}
						onClick={() => {
							if (showCode) {
								setShowCode(false);
							} else {
								setShowCode(true);
								// ショートコードの表示を待ってから全選択する
								setTimeout(function () {
									document
										.querySelector(
											`.swl-setting-balloon__item[data-id="${id}"] .swl-setting__codeCopyBox`
										)
										.select();
								}, 100);
							}
						}}
					/>
					<Button
						isSecondary
						className='swl-setting-balloon__copy swl-setting-balloon__btn'
						label={__('このセットを複製する', 'swell')}
						icon={stack}
						onClick={() => {
							copyBalloon(id);
						}}
					/>
					<Button
						isDestructive
						className='swl-setting-balloon__delete swl-setting-balloon__btn'
						label={__('このセットを削除する', 'swell')}
						icon={close}
						onClick={() => {
							deleteBalloon(id);
						}}
					/>
				</div>
				<a href={editUrl} className='swl-setting-balloon__link'>
					<div className='swl-setting-balloon__ttl'>{title}</div>
					{balloonPreview}
				</a>
				<div
					className='swl-setting-balloon__code'
					role='button'
					tabIndex='0'
					onClick={() => {
						setShowCode(false);
					}}
					onKeyDown={(event) => {
						event.stopPropagation();
						// check keys if you want
						if (13 === event.keyCode) {
							setShowCode(false);
						}
					}}
				>
					<input
						className='swl-setting__codeCopyBox code'
						type='text'
						readOnly
						value={`[speech_balloon id="${id}"]${__(
							'ふきだしテキストをここに入力',
							'swell'
						)}[/speech_balloon]`}
						onClick={(event) => {
							event.stopPropagation();
						}}
						onFocus={(event) => {
							event.stopPropagation();
							event.target.select();
						}}
					/>
				</div>
			</div>
		</li>
	);
}
