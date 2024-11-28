<?php
namespace SWELL_Theme\Customizer\Control;

if ( ! defined( 'ABSPATH' ) ) exit;

class Clear_Media_Control extends \WP_Customize_Control {

	//追加したメンバ変数
	public $classname = '';
	public $target_id = '';

	protected function render() {
		$id    = 'customize-control-' . str_replace( [ '[', ']' ], [ '-', '' ], $this->id );
		$class = 'swl-clear-media-control customize-control';

		if ( isset( $this->classname ) ) {
			$class .= ' ' . $this->classname; //追加した処理
		}

		printf( '<li id="%s" class="%s">', esc_attr( $id ), esc_attr( $class ) );
		$this->render_content();
		echo '</li>';
	}


	public function render_content() {
		$id        = $this->id;
		$target_id = $this->target_id;
		if ( ! $id) return false;
		?>
		<div class='swl-clear-media-control__body' data-id="<?=esc_attr( $id )?>">
			<p class="swl-clear-media-control__txt"><?=esc_html__( 'メディアライブラリに存在しない画像のIDがセットされています。', 'swell' )?></p>
			<button type="button" class="button button-primary swl-clear-media-control__btn"><?=esc_html__( '削除', 'swell' )?></button>
		</div>
		<script>
			(function ($) {
				wp.customize.bind('ready', function () {
					var theClearMediaButton = $('[data-id="<?=esc_attr( $id )?>"] .swl-clear-media-control__btn');
					theClearMediaButton.click(function(){
						wp.customize('loos_customizer[<?=esc_attr( $target_id )?>]', function( value ) {
							value.set('');
						});
						$('.swl-clear-media-control__body[data-id="<?=esc_attr( $id )?>"]').remove();
					});

					// 画像が再設定された場合
					wp.customize('loos_customizer[<?=esc_attr( $target_id )?>]', function (value) {
						value.bind(function (to) {
							$('.swl-clear-media-control__body[data-id="<?=esc_attr( $id )?>"]').remove();
						});
					});
				});
			})(window.jQuery);
		</script>
		<?php
	}

}
