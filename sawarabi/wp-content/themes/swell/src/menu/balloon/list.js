/**
 * @WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useEffect, useState, useCallback } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';
import { Button } from '@wordpress/components';
import { addQueryArgs } from '@wordpress/url';

/**
 * @SWELL dependencies
 */
import { swellApiPath } from './index';
import BalloonListItem from './list-item';

/**
 * @Others dependencies
 */
import ReactPaginate from 'react-paginate';

// 並び替えアニメーション用の処理
const setSwitchAnimation = (item1, item2, phase) => {
	const existItem1 = null !== item1;
	const existItem2 = null !== item2;

	if (1 === phase) {
		if (existItem1) item1.classList.add('-to-next');
		if (existItem2) item2.classList.add('-to-prev');
	} else if (2 === phase) {
		if (existItem1) item1.classList.add('-hide');
		if (existItem2) item2.classList.add('-hide');
	} else if (3 === phase) {
		if (existItem1) item1.classList.add('-show');
		if (existItem2) item2.classList.add('-show');
		if (existItem1) item1.classList.remove('-hide');
		if (existItem2) item2.classList.remove('-hide');
	} else if (4 === phase) {
		if (existItem1) item1.classList.remove('-show');
		if (existItem2) item2.classList.remove('-show');
		if (existItem1) item1.classList.remove('-to-next');
		if (existItem2) item2.classList.remove('-to-prev');
	}
};

// const perPageList = [30, 60, 90, 120];
export default function BalloonList() {
	// REST APIの通信中かどうか
	const [isApiLoaded, setIsApiLoaded] = useState(false);

	// 複製・削除処理中かどうか
	const [isWaiting, setIsWaiting] = useState(false);

	// REST API レスポンスメッセージ
	const [apiMessage, setApiMessage] = useState();

	// ふきだしデータの配列 (全部)
	const [balloonList, setBalloonList] = useState([]);

	// ふきだしデータの配列（絞り込み後）
	const [filteredBalloonList, setFilteredBalloonList] = useState([]);

	// 絞り込み検索ワード
	const [searchWord, setSearchWord] = useState('');

	// 1ページあたりの表示数
	const [perPage, setPerPage] = useState(30); // eslint-disable-line no-unused-vars

	// ページ番号
	const [page, setPage] = useState(0);

	const offset = page * perPage;

	// ふきだしデータの初回セット
	useEffect(() => {
		apiFetch({
			path: swellApiPath,
			method: 'GET',
		}).then((res) => {
			setIsApiLoaded(true);
			setBalloonList(res);
			setFilteredBalloonList(res); //初期状態は setBalloonList = setFilteredBalloonList
		});
	}, []);

	// ふきだしデータの絞り込み検索
	const searchBalloon = useCallback(
		(_s) => {
			const escapedWord = _s.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); // 正規表現向けの文字をエスケープ
			const regEx = new RegExp(escapedWord.toLowerCase().trim());

			setFilteredBalloonList(
				(balloonList || []).filter(({ title }) => {
					return title.toLowerCase().match(regEx);
				})
			);
		},
		[balloonList]
	);

	// ふきだしリストの更新・絞り込み検索結果を反映
	useEffect(() => {
		if (!isApiLoaded) return;

		if (searchWord) {
			searchBalloon(searchWord);
		} else {
			setFilteredBalloonList(balloonList);
		}
	}, [balloonList, searchWord]);

	// ふきだしデータの複製
	const copyBalloon = useCallback(
		(id) => {
			if (!id) return;

			// eslint-disable-next-line no-alert
			if (!window.confirm(__('本当に複製しますか？', 'swell'))) return;

			setIsWaiting(true);

			// データ
			apiFetch({
				path: `${swellApiPath}-copy`,
				method: 'POST',
				data: { id },
			})
				.then((res) => {
					// state更新

					setBalloonList([res, ...balloonList]);

					setApiMessage({
						status: 'updated',
						text: res.message || __('複製しました。', 'swell'),
					});

					setIsWaiting(false);
				})
				.catch((res) => {
					setApiMessage({
						status: 'error',
						text: res.message || __('エラーが発生しました。', 'swell'),
					});
					setIsWaiting(false);
				});
		},
		[balloonList]
	);

	// ふきだしデータの削除
	const deleteBalloon = useCallback(
		(id) => {
			if (!id) return;

			// eslint-disable-next-line no-alert
			if (window.confirm(__('本当に削除してもいいですか？', 'swell'))) {
				setIsWaiting(true);

				// データ削除
				apiFetch({
					path: swellApiPath,
					method: 'DELETE',
					data: { id },
				})
					.then((res) => {
						// state更新
						const newBalloonList = balloonList.filter((balloon) => {
							return balloon.id !== id;
						});
						setBalloonList(newBalloonList);

						setApiMessage({
							status: 'updated',
							text: res.message || __('削除しました。', 'swell'),
						});

						setIsWaiting(false);
					})
					.catch((res) => {
						setApiMessage({
							status: 'error',
							text: res.message || __('エラーが発生しました。', 'swell'),
						});
						setIsWaiting(false);
					});
			}
		},
		[balloonList]
	);

	// ふきだしデータの並び替え
	const swapBallons = useCallback(
		(idx, direction) => {
			if (idx === undefined || !direction) return;
			if (direction !== 'prev' && direction !== 'next') return;

			// filteredBalloonListの全体の中でのindexを計算。idxはページャーで区切られた表示数の中での数。
			const index = idx + offset;

			// 並び替える二つの吹き出しをセット
			const balloon1 =
				direction === 'prev' ? filteredBalloonList[index - 1] : filteredBalloonList[index];
			const balloon2 =
				direction === 'prev' ? filteredBalloonList[index] : filteredBalloonList[index + 1];

			if (!balloon1 || !balloon2) return;

			const li1 = document.querySelector(
				`.swl-setting-balloon__item[data-id="${balloon1.id}"]`
			);
			const li2 = document.querySelector(
				`.swl-setting-balloon__item[data-id="${balloon2.id}"]`
			);

			setSwitchAnimation(li1, li2, 1);

			setTimeout(() => {
				setSwitchAnimation(li1, li2, 2);

				// 並び替え
				apiFetch({
					path: `${swellApiPath}-sort`,
					method: 'POST',
					data: { balloon1, balloon2 },
				})
					.then((res) => {
						// state更新
						setBalloonList(res);

						// アニメーション用クラスのつけ外し
						setTimeout(() => {
							setSwitchAnimation(li1, li2, 3);
						}, 100);

						setTimeout(() => {
							setSwitchAnimation(li1, li2, 4);
						}, 1100);
					})
					.catch((res) => {
						setApiMessage({
							status: 'error',
							text: res.message || __('エラーが発生しました。', 'swell'),
						});
					});
			}, 400);
		},
		[filteredBalloonList, offset]
	);

	// null返すのが早すぎると、「Rendered more hooks than during the previous render.」エラーになる。
	if (!isApiLoaded) {
		return null;
	}

	// 新規ふきだし追加リンク
	const newEditUrl = addQueryArgs('admin.php', {
		page: 'swell_balloon',
		post_new: null,
	});

	const lastPage = Math.ceil(filteredBalloonList.length / perPage); // 端数切り上げ。

	const slicedFilteredBalloonList = filteredBalloonList.slice(offset, offset + perPage);

	return (
		<>
			{apiMessage && !isWaiting && (
				<div className={`notice is-dismissible ${apiMessage.status}`}>
					<p>{apiMessage.text}</p>
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
			<div className='swl-setting__body swl-setting-balloon' disabled={isWaiting}>
				<div className='swl-setting__controls'>
					<a className='components-button is-primary swl-setting__new' href={newEditUrl}>
						{__('新規ふきだし追加', 'swell')}
					</a>
					<input
						className='swl-setting__search'
						type='text'
						placeholder={__('ふきだしセットを検索…', 'swell')}
						value={searchWord}
						onChange={(e) => {
							setSearchWord(e.target.value); // 検索ワードのstate更新
						}}
					/>
				</div>
				{/* <div className='swl-setting__perPage'>
					<ButtonGroup>
						{perPageList.map((_pp) => (
							<Button
								isPrimary={_pp === perPage}
								onClick={() => {
									setPerPage(_pp);
								}}
								key={_pp}
							>
								{_pp}
							</Button>
						))}
					</ButtonGroup>
					<input
						className='swl-setting__perPage'
						type='number'
						value={perPage}
						onChange={(e) => {
							let newPerPage = parseInt(e.target.value);
							if (isNaN(newPerPage) || !newPerPage || 1 > newPerPage) {
								newPerPage = 1;
							}
							setPerPage(newPerPage);
						}}
					/>
				</div> */}
				{!filteredBalloonList.length ? (
					<p>{__('ふきだしデータがまだありません。', 'swell')}</p>
				) : (
					<>
						<ul className='swl-setting-balloon__list'>
							{slicedFilteredBalloonList.map((balloonData, idx) => {
								return (
									<BalloonListItem
										key={idx}
										isFirst={idx + offset === 0}
										isLast={idx + offset === filteredBalloonList.length - 1}
										{...{
											idx,
											balloonData,
											copyBalloon,
											deleteBalloon,
											swapBallons,
										}}
									/>
								);
							})}
						</ul>
						<ReactPaginate
							// initialPage={1} // 初期ページあのセット。※ 0始まり。
							// forcePage={1}
							pageCount={lastPage} // 必須。総ページ数。
							pageRangeDisplayed={5} // 必須。上記の「今いるページの前後」の番号をいくつ表示させるかを決めます。
							marginPagesDisplayed={1} // 必須。先頭と末尾に表示するページの数。
							onPageChange={(pageData) => {
								// ※ pageData.selected は 0 始まり。
								// console.log(pageData.selected);
								setPage(pageData.selected);
							}}
							containerClassName='pagination' //ページネーションリンクの親要素のクラス名
							pageClassName='pagination__item' //各子要素(li要素)のクラス名
							pageLinkClassName='pagination__link' //ページネーションのリンクのクラス名
							activeClassName='active' //今いるページ番号のクラス名。今いるページの番号だけ太字にしたりできます
							previousLabel='<' //前のページ番号に戻すリンクのテキスト
							nextLabel='>' //次のページに進むボタンのテキスト
							previousClassName='pagination__item -prev' // '<'の親要素(li)のクラス名
							previousLinkClassName='pagination__link -prev' //'<'のリンクのクラス名
							nextClassName='pagination__item -next' //'>'の親要素(li)のクラス名
							nextLinkClassName='pagination__link -next' //'>'のリンクのクラス名
							breakClassName='pagination__item -break' // 上記の「…」のクラス名
							breakLinkClassName='pagination__link -break' // 「…」の中のリンクにつけるクラス
							// disabledClassName='disabled' //先頭 or 末尾に行ったときにそれ以上戻れ(進め)なくするためのクラス
							// breakLabel='...' // ページがたくさんあるときに表示しない番号に当たる部分をどう表示するか
						/>
					</>
				)}
			</div>
		</>
	);
}
