/**
 * @WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useState } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';
import { Button } from '@wordpress/components';

/**
 * @SWELL dependencies
 */
import { swellApiPath } from './index';

export default function BalloonMigrate() {
	// 移行処理が始まっているかどうか
	const [isWaiting, setIsWaiting] = useState(false);

	// REST API レスポンスメッセージ
	const [errMessage, setErrMessage] = useState('');

	return (
		<>
			{errMessage && (
				<div className={`notice is-dismissible error`}>
					<p>{errMessage}</p>
				</div>
			)}
			<div className='swl-setting__body swl-setting-balloon' disabled={isWaiting}>
				<p>
					{__(
						'旧バージョンの古いデータが残っています。以下のボタンからデータの変換を行ってください。',
						'swell'
					)}
				</p>
				<Button
					isPrimary
					className=''
					onClick={() => {
						if (isWaiting) return;
						// eslint-disable-next-line no-alert
						if (window.confirm(__('本当にデータを移行してもいいですか？', 'swell'))) {
							setIsWaiting(true);

							apiFetch({
								path: swellApiPath,
								method: 'PATCH',
							})
								.then((res) => {
									if ('ok' === res.status) {
										// 旧ふきだしメニューを非表示にするためにリロード
										location.reload();
									} else {
										setErrMessage(__('データ移行に失敗しました。', 'swell'));
									}
								})
								.catch((res) => {
									setErrMessage(res.message);
								});
						}
					}}
				>
					{__('旧データを新データへ移行する', 'swell')}
				</Button>
				<p>
					{__(
						'※データの変換を行うと、SWELLのバージョンをダウングレードした時にふきだしが正常に呼び出せなくなる可能性があります。',
						'swell'
					)}
					<br />
					{__('バックアップを取ってから実行してください。', 'swell')}
				</p>
			</div>
		</>
	);
}
