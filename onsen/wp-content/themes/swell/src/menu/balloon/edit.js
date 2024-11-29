/**
 * @WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useState, useEffect, createInterpolateElement } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';
import { Button, ButtonGroup, TextControl, CheckboxControl } from '@wordpress/components';
import { addQueryArgs } from '@wordpress/url';
import { Icon, close, arrowLeft } from '@wordpress/icons';
import { RichText, MediaUpload } from '@wordpress/block-editor';

/**
 * @SWELL dependencies
 */
import { swellApiPath, iconPlaceholder } from './index';
import blnIcon from '@swell-guten/blocks/balloon/icon/setting';
import {
	shapeBtns,
	typeBtns,
	alignBtns,
	borderBtns,
	balloonColors,
} from '@swell-guten/blocks/balloon/_config';
import SwlColorPicker from '@swell-guten/components/SwlColorPicker';

/**
 * @Other dependencies
 */
import classnames from 'classnames';

export default function BalloonEdit({ id, setId }) {
	// タイトル
	const [title, setTitle] = useState('');

	// 入力フォームエラーメッセージ
	const [formError, setFormError] = useState();

	// ふきだしデータ
	const [balloonData, setBalloonData] = useState({
		icon: undefined,
		name: undefined,
		shape: 'square',
		type: 'speaking',
		align: 'left',
		border: 'none',
		col: 'gray',
		spVertical: '',
	});

	// REST APIでのデータ読み込みが完了したかどうか
	const [isApiLoaded, setIsApiLoaded] = useState(!id);

	// 保存・削除処理中かどうか
	const [isWaiting, setIsWaiting] = useState(false);

	// REST API レスポンスメッセージ
	const [apiMessage, setApiMessage] = useState();

	// 保存ボタンのテキスト
	const saveLabel = id ? __('更新', 'swell') : __('登録', 'swell');

	// ふきだしデータの取得
	useEffect(() => {
		if (id) {
			apiFetch({
				path: `${swellApiPath}?id=${id}`,
				method: 'GET',
			})
				.then((res) => {
					setTitle(res.title);
					setBalloonData({ ...balloonData, ...res.data });
					setIsApiLoaded(true);
				})
				.catch(() => {
					// データが見つからなかった場合は、新規登録扱いにする
					setId();
					setIsApiLoaded(true);
				});
		}
	}, []);

	// エディター設定URL
	const settingUrl = addQueryArgs('admin.php', {
		page: 'swell_settings_editor',
		tab: 'balloon',
	});

	// ふきだし一覧リンク
	const listUrl = addQueryArgs('admin.php', {
		page: 'swell_balloon',
	});

	// 登録・更新
	const saveBalloon = (event) => {
		// 通常のフォームサブミットを停止
		event.preventDefault();

		// 入力チェック（タイトル）
		if (title === '') {
			setFormError({
				item: 'title',
				message: __('※ ふきだしセットのタイトルを入力してください', 'swell'),
			});
			return;
		}

		setIsWaiting(true);

		apiFetch({
			path: swellApiPath,
			method: 'POST',
			data: {
				id,
				title,
				data: balloonData,
			},
		})
			.then((res) => {
				setApiMessage({
					status: 'updated',
					text: res.message || __('設定を保存しました。', 'swell'),
				});

				// 新規登録時はIDのstateを更新
				if (res.insertId) {
					setId(res.insertId);
				}

				setIsWaiting(false);
			})
			.catch((res) => {
				setApiMessage({
					status: 'error',
					text: res.message || __('エラーが発生しました。', 'swell'),
				});
				setIsWaiting(false);
			});
	};

	// 複製
	const copyBalloon = (event) => {
		// 通常のフォームサブミットを停止
		event.preventDefault();

		// eslint-disable-next-line no-alert
		if (!window.confirm(__('本当に複製しますか？', 'swell'))) return;

		// setIsWaiting(true);

		apiFetch({
			path: `${swellApiPath}-copy`,
			method: 'POST',
			data: { id },
		})
			.then((res) => {
				setIsWaiting(false);
				// 複製されたふきだしの編集画面に遷移
				if (res.id) {
					// ふきだし編集基本リンク
					const editUrl = addQueryArgs('admin.php', {
						page: 'swell_balloon',
						id: res.id,
					});
					window.location.href = editUrl;
				}
			})
			.catch((res) => {
				setApiMessage({
					status: 'error',
					text: res.message || __('エラーが発生しました。', 'swell'),
				});
				setIsWaiting(false);
			});
	};

	// ふきだしデータの削除
	const deleteBalloon = () => {
		if (!id) return;

		// eslint-disable-next-line no-alert
		if (window.confirm(__('本当に削除してもいいですか？', 'swell'))) {
			setIsWaiting(true);

			apiFetch({
				path: swellApiPath,
				method: 'DELETE',
				data: { id },
			})
				.then(() => {
					window.location.href = listUrl;
				})
				.catch((res) => {
					setApiMessage({
						status: 'error',
						text: res.message || __('エラーが発生しました。', 'swell'),
					});
					setIsWaiting(false);
				});
		}
	};

	return (
		<>
			{apiMessage && !isWaiting && (
				<div className={`notice is-dismissible ${apiMessage.status}`}>
					<p>
						{apiMessage.text}
						<a href={listUrl} style={{ marginLeft: '8px' }}>
							{__('ふきだしセットの一覧に戻る', 'swell')}
						</a>
					</p>
					<Button
						className='notice-dismiss'
						onClick={() => {
							setApiMessage();
						}}
					>
						<span className='screen-reader-text'>
							{__('この通知を非表示にする。', 'swell')}
						</span>
					</Button>
				</div>
			)}
			{isApiLoaded && (
				<div className='swl-setting__body is-edit-balloon'>
					<div className='swl-setting__controls'>
						<Button disabled={isWaiting} isPrimary onClick={saveBalloon}>
							{saveLabel}
						</Button>
						{!!id && (
							<>
								<Button disabled={isWaiting} isSecondary onClick={copyBalloon}>
									{__('複製', 'swell')}
								</Button>
								<Button
									disabled={isWaiting}
									isDestructive
									// icon={close}
									// iconSize={16}
									onClick={deleteBalloon}
								>
									{__('削除', 'swell')}
								</Button>
							</>
						)}
					</div>
					<form onSubmit={saveBalloon}>
						<div className='swl-setting__editTitle'>
							<TextControl
								placeholder={__('ふきだしセットのタイトルを入力…', 'swell')}
								value={title}
								onChange={(val) => {
									setTitle(val);
									// if (val === '') {
									// 	setFormError({
									// 		item: 'title',
									// 		message: {__('ふきだしセットのタイトルを入力してください', 'swell')},
									// 	});
									// } else {
									// 	setFormError();
									// }
								}}
							/>
							{formError?.item === 'title' && (
								<p className='swl-setting__error'>{formError.message}</p>
							)}
						</div>
						<div className='swell_settings_balloon_edit' disabled={isWaiting}>
							<div className='swell_settings_balloon_edit__inner -left'>
								<div
									className={`c-balloon -bln-${balloonData.align}`}
									data-col={balloonData.col || 'gray'}
								>
									<div className={`c-balloon__icon -${balloonData.shape}`}>
										{balloonData.icon && (
											<Button
												className='swell_settings_balloon_edit__iconDelete'
												isDestructive
												icon={close}
												iconSize={12}
												label={__('アイコン画像を削除', 'swell')}
												onClick={() => {
													setBalloonData({
														...balloonData,
														icon: undefined,
													});
												}}
											/>
										)}
										<MediaUpload
											allowedTypes={'image'}
											onSelect={(media) => {
												const icon = media.sizes.thumbnail
													? media.sizes.thumbnail.url
													: media.url;
												setBalloonData({
													...balloonData,
													icon,
												});
											}}
											render={({ open }) => (
												<Button
													onClick={open}
													className='swell_settings_balloon_edit__iconSelect'
													label={__('画像を選択', 'swell')}
													showTooltip={false}
												>
													<span>{__('画像を選択', 'swell')}</span>
												</Button>
											)}
										/>
										<img
											src={balloonData.icon || iconPlaceholder}
											alt=''
											className='c-balloon__iconImg'
											width='80px'
										/>
										<RichText
											className={classnames('c-balloon__iconName', {
												'-empty': RichText.isEmpty(balloonData.name),
											})}
											value={balloonData.name}
											placeholder={__('アイコン名をここに入力…', 'swell')}
											onChange={(val) => {
												setBalloonData({
													...balloonData,
													name: val,
												});
											}}
										/>
									</div>
									<div
										className={`c-balloon__body -${balloonData.type} -border-${balloonData.border}`}
									>
										<div className='c-balloon__text'>
											{__('ふきだしの内容がここに入ります', 'swell')}
											<span className='c-balloon__shapes'>
												<span className='c-balloon__before'></span>
												<span className='c-balloon__after'></span>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div className='swell_settings_balloon_edit__inner -right'>
								<div className='swell_settings_balloon_edit__item'>
									<div className='swell_settings_balloon_edit__subttl'>
										{__('アイコンの丸枠', 'swell')}
									</div>
									<ButtonGroup>
										{shapeBtns.map((btn) => {
											const isSelected = btn.val === balloonData.shape;
											return (
												<Button
													text={btn.label}
													icon={blnIcon.shape[btn.val]}
													isPrimary={isSelected}
													onClick={() => {
														setBalloonData({
															...balloonData,
															shape: btn.val,
														});
													}}
													key={`shape_${btn.val}`}
												/>
											);
										})}
									</ButtonGroup>
								</div>
								<div className='swell_settings_balloon_edit__item'>
									<div className='swell_settings_balloon_edit__subttl'>
										{__('ふきだしの形', 'swell')}
									</div>
									<ButtonGroup>
										{typeBtns.map((btn) => {
											const isSelected = btn.val === balloonData.type;
											return (
												<Button
													text={btn.label}
													icon={blnIcon.type[btn.val]}
													isPrimary={isSelected}
													onClick={() => {
														setBalloonData({
															...balloonData,
															type: btn.val,
														});
													}}
													key={`type_${btn.val}`}
												/>
											);
										})}
									</ButtonGroup>
								</div>
								<div className='swell_settings_balloon_edit__item'>
									<div className='swell_settings_balloon_edit__subttl'>
										{__('ふきだしの向き', 'swell')}
									</div>
									<ButtonGroup>
										{alignBtns.map((btn) => {
											const isSelected = btn.val === balloonData.align;
											return (
												<Button
													text={btn.label}
													icon={blnIcon.align[btn.val]}
													isPrimary={isSelected}
													onClick={() => {
														setBalloonData({
															...balloonData,
															align: btn.val,
														});
													}}
													key={`align_${btn.val}`}
												/>
											);
										})}
									</ButtonGroup>
								</div>
								<div className='swell_settings_balloon_edit__item'>
									<div className='swell_settings_balloon_edit__subttl'>
										{__('ふきだしの線', 'swell')}
									</div>
									<ButtonGroup>
										{borderBtns.map((btn) => {
											const isSelected = btn.val === balloonData.border;
											return (
												<Button
													text={btn.label}
													icon={blnIcon.border[btn.val]}
													isPrimary={isSelected}
													onClick={() => {
														setBalloonData({
															...balloonData,
															border: btn.val,
														});
													}}
													key={`border_${btn.val}`}
												/>
											);
										})}
									</ButtonGroup>
								</div>

								<div className='swell_settings_balloon_edit__item  -wide'>
									<div className='swell_settings_balloon_edit__subttl'>
										{__('ふきだしの色', 'swell')}
									</div>
									<SwlColorPicker
										// defaultValueは指定しない → カラーを空データにはしない
										type='swl-capbox-color'
										value={balloonData.col || 'gray'}
										colors={balloonColors}
										onClick={(val) => {
											setBalloonData({
												...balloonData,
												col: val || '',
											});
										}}
									/>
									<p className=''>
										{createInterpolateElement(
											__(
												'※ ふきだしカラーは「SWELL設定」内の「<a>エディター設定</a>」から編集できます。',
												'swell'
											),
											{
												a: (
													// eslint-disable-next-line jsx-a11y/anchor-has-content
													<a
														href={settingUrl}
														target='_blank'
														rel='noreferrer'
													/>
												),
											}
										)}
									</p>
								</div>
								<div className='swell_settings_balloon_edit__item -wide'>
									<div className='swell_settings_balloon_edit__subttl'>
										{__('テキストとアイコンの並び', 'swell')}
									</div>
									<CheckboxControl
										label={__('スマホ表示で縦並びにする', 'swell')}
										checked={'1' === balloonData.spVertical}
										onChange={(checked) => {
											setBalloonData({
												...balloonData,
												spVertical: '',
											});
											if (false === checked) {
												setBalloonData({
													...balloonData,
													spVertical: '',
												});
											} else {
												setBalloonData({
													...balloonData,
													spVertical: '1',
												});
											}
										}}
									/>
								</div>
							</div>
						</div>
					</form>
					<a href={listUrl} className='swl-setting__backLink'>
						<Icon icon={arrowLeft} />
						{__('ふきだしセットの一覧に戻る', 'swell')}
					</a>
				</div>
			)}
		</>
	);
}
