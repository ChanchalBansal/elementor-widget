<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Team_Member_Card_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'team_member_card';
    }

    public function get_title() {
        return __( 'Team Member Card', 'tmc' );
    }

    public function get_icon() {
        return 'eicon-person';
    }

    public function get_categories() {
        return [ 'custom-widgets' ];
    }

    protected function register_controls() {
        
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Team Member Info', 'tmc' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'name',
            [
                'label' => __( 'Name', 'tmc' ),
                'type'  => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'John Doe', 'tmc' ),
                'placeholder' => __( 'Enter name', 'tmc' ),
            ]
        );

        $this->add_control(
            'role',
            [
                'label' => __( 'Role', 'tmc' ),
                'type'  => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Developer', 'tmc' ),
                'placeholder' => __( 'Enter role', 'tmc' ),
            ]
        );

        $this->add_control(
            'bio',
            [
                'label' => __( 'Bio', 'tmc' ),
                'type'  => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __( 'Short bio goes here...', 'tmc' ),
                'placeholder' => __( 'Short bio', 'tmc' ),
            ]
        );

        $this->add_control(
            'photo',
            [
                'label' => __( 'Photo', 'tmc' ),
                'type'  => \Elementor\Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'linkedin',
            [
                'label' => __( 'LinkedIn URL', 'tmc' ),
                'type'  => \Elementor\Controls_Manager::URL,
                'placeholder' => 'https://linkedin.com/user',
                'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $name = isset( $settings['name'] ) ? sanitize_text_field( $settings['name'] ) : '';
		$role = isset( $settings['role'] ) ? sanitize_text_field( $settings['role'] ) : '';
		$bio  = isset( $settings['bio'] ) ? wp_kses_post( $settings['bio'] ) : '';
		$link = isset( $settings['linkedin'] ) ? $settings['linkedin'] : array();
		$photo = '';

        // Photo handling
		if ( ! empty( $settings['photo']['id'] ) ) {
			$photo_src = wp_get_attachment_image_src( (int) $settings['photo']['id'], 'medium' );
			if ( $photo_src ) {
				$photo = esc_url( $photo_src[0] );
			}
		} elseif ( ! empty( $settings['photo']['url'] ) ) {
			$photo = esc_url( $settings['photo']['url'] );
		}

        // LinkedIn attributes
		$link_url = '';
		$target = '';
		$rel = '';
		if ( is_array( $link ) && ! empty( $link['url'] ) ) {
			$link_url = esc_url( $link['url'] );
			$target = ! empty( $link['is_external'] ) ? ' target="_blank"' : '';
			$rel = ! empty( $link['nofollow'] ) ? ' rel="nofollow noopener noreferrer"' : ' rel="noopener noreferrer"';
		}

        ?>
        <div class="tmc-card" style="
            border:1px solid #ddd;
            padding:20px;
            max-width:300px;
            text-align:center;
            border-radius:10px;
        ">
        <style>
				.tmc-team-card{
					box-sizing: border-box;
					max-width: 320px;
					border: 1px solid #e6e6e6;
					padding: 16px;
					border-radius: 8px;
					display:flex;
					gap:12px;
					align-items:flex-start;
					background:#fff;
					font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial;
				}
				.tmc-team-card .tmc-photo{
					flex: 0 0 72px;
					width:72px;
					height:72px;
					border-radius:50%;
					overflow:hidden;
					background:#f4f4f4;
					display:block;
				}
				.tmc-team-card .tmc-photo img{
					width:100%;
					height:100%;
					object-fit:cover;
					display:block;
				}
				.tmc-team-card .tmc-content{
					flex:1 1 auto;
				}
				.tmc-team-card .tmc-name{
					margin:0 0 4px 0;
					font-size:16px;
					font-weight:600;
					line-height:1.1;
				}
				.tmc-team-card .tmc-role{
					margin:0 0 8px 0;
					font-size:13px;
					color:#666;
				}
				.tmc-team-card .tmc-bio{
					margin:0 0 8px 0;
					font-size:13px;
					color:#333;
				}
				.tmc-team-card .tmc-links a{
					font-size:13px;
					text-decoration:none;
					color:#0a66c2; /* LinkedIn-ish color */
				}
			</style>
            <?php if($photo): ?>
                <img src="<?php echo esc_url($photo); ?>" 
                     alt="<?php echo esc_attr($name); ?>" 
                     style="width:100px;height:100px;object-fit:cover;border-radius:50%;margin-bottom:15px;">
            <?php endif; ?>

            <div class="tmc-content">
				<h3 class="tmc-name"><?php echo esc_html( $name ); ?></h3>
				<div class="tmc-role"><?php echo esc_html( $role ); ?></div>
				<div class="tmc-bio"><?php echo $bio; // already sanitized by wp_kses_post ?></div>
				<?php if ( $link_url ) : ?>
					<div class="tmc-links">
						<a href="<?php echo esc_url( $link_url ); ?>"<?php echo $target . $rel; ?>>
							<?php esc_html_e( 'LinkedIn profile', 'tmc-elementor' ); ?>
						</a>
					</div>
				<?php endif; ?>
			</div>
        </div>
        <?php
    }
}
