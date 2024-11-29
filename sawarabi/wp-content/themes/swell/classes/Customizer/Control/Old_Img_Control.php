<?php
namespace SWELL_Theme\Customizer\Control;

if ( ! defined( 'ABSPATH' ) ) exit;

class Old_Img_Control extends \WP_Customize_Control {

	//追加したメンバ変数
	public $classname = '';
	public $target_id = '';

	protected function render() {
		$id    = 'customize-control-' . str_replace( [ '[', ']' ], [ '-', '' ], $this->id );
		$class = 'swl-old-img-control customize-control';

		if ( isset( $this->classname ) ) {
			$class .= ' ' . $this->classname; //追加した処理
		}

		printf( '<li id="%s" class="%s">', esc_attr( $id ), esc_attr( $class ) );
		$this->render_content();
		echo '</li>';
	}


	public function render_content() {
		$id = $this->id; // 'loos_customizer[xxx]'
		?>
		<?php if ( ! empty( $this->label ) ) : ?>
			<label for="<?php echo esc_attr( $id ); ?>" class="customize-control-title">
				<?php echo esc_html__( '【旧】', 'swell' ) . esc_html( $this->label ); ?>
			</label>
		<?php endif; ?>
		<span class="swl-old-img-control__description">
			<?=esc_html__( 'URL形式の古いデータが残っています。削除してから再設定してください。', 'swell' )?>
		</span>
		<div class='swl-old-img-control__body'>
			<input
				type="text"
				id="<?php echo esc_attr( $id ); ?>"
				class="swl-old-img-control__txt"
				value="<?php echo esc_attr( $this->value() ); ?>"
				<?php $this->link(); ?>
			/>
			<button type="button" class="button button-primary swl-old-img-control__btn" data-id="<?=esc_attr( $id )?>"><?=esc_html__( '削除', 'swell' )?></button>
		</div>
		<script>
			(function ($) {
				wp.customize.bind('ready', function () {
					var theClearMediaButton = $('.swl-old-img-control__btn[data-id="<?=esc_attr( $id )?>"]');
					theClearMediaButton.click(function(){
						wp.customize('<?=esc_attr( $id )?>', function( value ) {
							value.set('');
						});
					});
				});
			})(window.jQuery);
		</script>
		<?php
	}

}
