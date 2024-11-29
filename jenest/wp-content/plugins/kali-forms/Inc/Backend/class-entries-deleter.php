<?php

namespace KaliForms\Inc\Backend;

if (!defined('ABSPATH')) {
	exit;
}

class Entries_Deleter
{
	/**
	 * Plugin slug
	 *
	 * @var string
	 */
	protected $slug = 'kaliforms';

	/**
	 * Forms that are eligible
	 *
	 * @var array
	 */
	private $forms = [];
	/**
	 * Basic constructor
	 *
	 * Entries deleter
	 */
	public function __construct()
	{
		$this->_collect_eligible_forms();
		add_action($this->slug . '_delete_entries', [$this, '_delete_entries']);
		$event = wp_get_scheduled_event($this->slug . '_delete_entries');
		if (!$event) {
			wp_schedule_event(strtotime('00:00:00'), 'daily', $this->slug . '_delete_entries');
		}
	}
	/**
	 * Get forms that are eligible for deletion
	 *
	 * @return void
	 */
	private function _collect_eligible_forms()
	{
		$args = [
			'post_type' => "{$this->slug}_forms",
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'meta_query' => [
				'relation' => 'AND',
				[
					'key' => "{$this->slug}_delete_entries_after",
					'value' => 0,
					'compare' => '>',
				],
				[
					'key' => "{$this->slug}_save_form_submissions",
					'value' => 1,
				],
			],
		];

		$query = new \WP_Query($args);
		wp_reset_postdata();

		foreach ($query->posts as $post) {
			$this->forms[] = $post->ID;
		};
	}

	public function _delete_entries()
	{
		$formWithEntries = [];

		foreach ($this->forms as $form) {
			$args = [
				'post_type'      => $this->slug . '_submitted',
				'meta_key'       => 'formId',
				'posts_per_page' => -1,
				'meta_query'     => [
					[
						'key'     => 'formId',
						'value'   => $form,
						'compare' => '=',
					],
				],
			];

			$query   = new \WP_Query($args);
			$counter = 0;
			if ($query->have_posts()) {
				$counter = $query->post_count;
			}
			wp_reset_postdata();

			if ($counter > 0) {
				$formWithEntries[] = [
					'id' => $form,
					'interval' => absint(get_post_meta($form, $this->slug . '_delete_entries_after', 0)),
				];
			}
		}

		foreach ($formWithEntries as $form) {
			$args = [
				'post_type'      => $this->slug . '_submitted',
				'meta_key'       => 'formId',
				'posts_per_page' => -1,
				'meta_query'     => [
					[
						'key'     => 'formId',
						'value'   => $form['id'],
						'compare' => '=',
					],
				],
			];

			$query = new \WP_Query($args);
			if ($query->have_posts()) {
				foreach ($query->posts as $post) {
					$diff = time() - strtotime($post->post_date);
					if ($diff > $form['interval'] * DAY_IN_SECONDS) {
						wp_delete_post($post->ID, true);
					}
				}
			}
			wp_reset_postdata();
		}
	}
}
