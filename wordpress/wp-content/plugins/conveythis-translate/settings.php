<div class="wrap">
	<form class="conveythis-widget-option-form" style="max-width: 60%; min-width: 1024px; position: relative;" method="post" action="options.php">

		<?php settings_fields( 'my-plugin-settings-group' ); ?>
		<?php do_settings_sections( 'my-plugin-settings-group' ); ?>

		<h3><?php echo __( 'Main configuration', 'conveythis-translate' ); ?></h3>

		<div id="customize-preview" style="display: none;">
			<div style="font-weight: 700; padding: 1em 1em; font-size: 1.3em;">
				<?php echo __( 'Preview', 'conveythis-translate' ); ?>
			</div>
			<div style="margin: 0; padding: 1em 1em; height: 45px; border: none; border-top: 1px solid rgba(34,36,38,.1);">
				<div id="customize-view-button" style="z-index: 1;"></div>
			</div>
		</div>

		
		<!-- -->

		<h4><?php echo __( 'API Key', 'conveythis-translate' ); ?></h4>
		<div style="margin: 10px 0 28px 0; width: 550px;">
			<div style="float: left; width: 190px;">
				<?php
					$message = __( 'Log in to %sConveyThis%s to get your API key.', 'conveythis-translate' );
					echo sprintf( $message, '<a target="_blank" href="https://www.conveythis.com/account/register/?utm_source=widget&utm_medium=wordpress">', '</a>' );
				?>
			</div>
			<div style="margin-left: 220px;">

				<input type="text" class="conveythis-input-text" name="api_key" value="<?php echo esc_attr( $this->api_key ); ?>" placeholder="pub_XXXXXXXX" />

			</div>
		</div>
		<div style="clear:both"></div>

		<!-- -->

		<h4><?php echo __( 'Source Language', 'conveythis-translate' ); ?></h4>
		<div style="margin: 10px 0 28px 0; width: 550px;">
			<div style="float: left; width: 190px;">
				<p style="padding: 0; margin: 0;">
					<?php echo __( 'What is the source (current) language of your website?', 'conveythis-translate' ); ?>
				</p>
			</div>
			<div style="margin-left: 220px;">

					<!-- Semantic -->
					<div class="ui fluid search selection dropdown">
						<input type="hidden" name="source_language" value="<?php echo $this->source_language; ?>">
						<i class="dropdown icon"></i>
						<div class="default text"><?php echo __( 'Select source language', 'conveythis-translate' ); ?></div>
						<div class="menu">

							<?php foreach( $this->languages as $language ): ?>

								<div class="item" data-value="<?php echo esc_attr( $language['code2'] ); ?>">
									<?php esc_html_e( $language['title'], 'conveythis-translate' ); ?>
								</div>

							<?php endforeach; ?>

						</div>
					</div>
			
			</div>
		</div>
		<div style="clear:both"></div>

		<!-- -->

		<h4><?php echo __( 'Target Languages', 'conveythis-translate' ); ?></h4>
		<div style="margin: 10px 0 28px 0; width: 550px;">
			<div style="float: left; width: 190px;">
				<p style="padding: 0; margin: 0;">
					<?php echo __( 'Choose languages you want to translate into.', 'conveythis-translate' ); ?>
				</p>
			</div>
			<div style="margin-left: 220px;">

					<!-- Semantic -->
					<div class="ui fluid multiple search selection dropdown">
						<input type="hidden" name="target_languages" value="<?php echo implode( ',', $this->target_languages ); ?>">
						<i class="dropdown icon"></i>
						<div class="default text">French, German, Italian, Portuguese …</div>
						<div class="menu">

						<?php foreach( $this->languages as $language ): ?>

							<div class="item" data-value="<?php echo esc_attr( $language['code2'] ); ?>">
								<?php esc_html_e( $language['title'], 'conveythis-translate' ); ?>
							</div>

						<?php endforeach; ?>

						</div>
					</div>

			</div>
		</div>
		<!-- <div style="margin: 20px 0; width: 565px;">
			<div style="float: left; width: 170px;"></div>
			<div style="margin-left: 220px;">
				<?php
					$message = __( 'On the free plan, you can only choose one target language. If you want to use more than 1 language, please %supgrade your plan%s.', 'conveythis-translate' );
					echo sprintf( $message, '<a target="_blank" href="https://www.conveythis.com/dashboard/pricing/?utm_source=widget&utm_medium=wordpress">', '</a>' );
				?>
			</div>
		</div> -->
		<div style="clear:both"></div>

		<!-- -->





		<h4><?php echo __( 'Automatic Language Redirection', 'conveythis-translate' ); ?></h4>
		<div style="margin: 10px 0 45px 0; width: 550px;">
			<div style="float: left; width: 220px;">
				<p style="padding: 0; margin: 0;">
					<?php echo __( "Redirect visitors to translated pages automatically based on user browser's settings.", 'conveythis-translate' ); ?>
				</p>
			</div>
			<div style="margin-left: 300px;">
			
				<br>
				<?php if(!empty($this->auto_translate) && $this->auto_translate == 1): ?>
					<input type="radio" id="auto_translate_yes" name="auto_translate" value="1" checked style="margin-left: 20px;"> Yes
					<input type="radio" id="auto_translate_no"  name="auto_translate" value="0" style="margin-left: 20px;"> No
				<?php else: ?>
					<input type="radio" id="auto_translate_yes" name="auto_translate" value="1" style="margin-left: 20px;"> Yes
					<input type="radio" id="auto_translate_no"  name="auto_translate" value="0" checked style="margin-left: 20px;"> No
				<?php endif; ?>
			</div>
		</div>
		<div style="clear:both"></div>

		<div style="margin: 20px 0; width: 565px;">
			<div style="float: left; width: 170px;"></div>
			<div style="margin-left: 220px;">
				<?php
					$message = __( 'This feature is not available on Free and Starter plans. If you want to use this feature, please %supgrade your plan%s.', 'conveythis-translate' );
					echo sprintf( $message, '<a target="_blank" href="https://www.conveythis.com/dashboard/pricing/?utm_source=widget&utm_medium=wordpress">', '</a>' );
				?>
			</div>
		</div>
		<div style="clear:both"></div>
		
		<div style="margin: 10px 0 30px 0; width: 550px;">
			<div style="float: left; width: 220px;">
				<p style="padding: 0; margin: 0;">
					<?php echo __( "Hide ConveyThis logo.", 'conveythis-translate' ); ?>
				</p>
			</div>
			<div style="margin-left: 300px;">
			
				<br>
				<?php if(!empty($this->hide_conveythis_logo) && $this->hide_conveythis_logo == 1): ?>
					<input type="radio" id="hide_conveythis_logo_yes" name="hide_conveythis_logo" value="1" checked style="margin-left: 20px;"> Yes
					<input type="radio" id="hide_conveythis_logo_no"  name="hide_conveythis_logo" value="0" style="margin-left: 20px;"> No
				<?php else: ?>
					<input type="radio" id="hide_conveythis_logo_yes" name="hide_conveythis_logo" value="1" style="margin-left: 20px;"> Yes
					<input type="radio" id="hide_conveythis_logo_no"  name="hide_conveythis_logo" value="0" checked style="margin-left: 20px;"> No
				<?php endif; ?>
			</div>
		</div>
		<div style="clear:both"></div>
		
		<div style="margin: 20px 0; width: 565px;">
			<div style="float: left; width: 170px;"></div>
			<div style="margin-left: 220px;">
				<?php
					$message = __( 'This feature is not available on Free plan. If you want to use this feature, please %supgrade your plan%s.', 'conveythis-translate' );
					echo sprintf( $message, '<a target="_blank" href="https://www.conveythis.com/dashboard/pricing/?utm_source=widget&utm_medium=wordpress">', '</a>' );
				?>
			</div>
		</div>
		<div style="clear:both"></div>
		
		
		<?php if( !empty( $this->api_key ) ): ?>

			<h4><?php echo __( 'Where are my translations?', 'conveythis-translate' ); ?></h4>

			<div style="margin: 10px 0 28px 0; width: 550px;">
				<div style="float: left; width: 190px;">
					<p style="padding: 0; margin: 0;">
						<?php echo __( 'You can find all your translations in your account', 'conveythis-translate' ); ?>
					</p>
				</div>
				<div style="margin-left: 220px;">

					<a target="_blank" href="https://www.conveythis.com/domains/?utm_source=widget&utm_medium=wordpress"><?php echo __( 'Edit My Translations', 'conveythis-translate' ); ?></a>
				
				</div>
			</div>

		<?php endif; ?>

		<!-- -->

		<br>
		<br>

		<div style="border-bottom: 1px solid rgba(34,36,38,.15); padding-bottom: 10px;">
			<a href="#" id="customize-tab-toogle"><?php echo __( 'Show more options', 'conveythis-translate' ); ?></a>
		</div>

		<div id="customize-tab" style="display: none">

			<h3><?php echo __( 'SEO', 'conveythis-translate' ); ?></h3>

			<!-- -->

			<div style="margin: 10px 0 28px 0; width: 800px;">
				<div style="float: left; width: 190px;">
					<?php echo __( 'Hreflang tags', 'conveythis-translate' ); ?>
				</div>
				<div style="margin-left: 220px;">

					<input type="checkbox" name="alternate" value="1" <?php checked( 1, $this->alternate, true ); ?>>
					<label><?php echo __( 'Add to all pages', 'conveythis-translate' ); ?></label>

				</div>
			</div>
			<div style="clear:both"></div>

			<!-- -->

			<h3><?php echo __( 'Customize Languages', 'conveythis-translate' ); ?></h3>

			<!-- -->

			<div style="margin: 10px 0 28px 0; width: 800px;">
				<div style="float: left; width: 190px;">
					<?php echo __( 'Languages in selectbox', 'conveythis-translate' ); ?>
				</div>
				<div style="margin-left: 220px;">

					<input type="checkbox" name="show_javascript" value="1" <?php checked( 1, $this->show_javascript, true ); ?>>
					<label><?php echo __( 'Show', 'conveythis-translate' ); ?></label>

				</div>
			</div>
			<div style="clear:both"></div>

			<!-- -->

			<div style="margin: 10px 0 28px 0; width: 800px;">
				<div style="float: left; width: 190px;">
					<?php echo __( 'Languages in menu', 'conveythis-translate' ); ?>
				</div>
				<div style="margin-left: 220px;">

						<?php echo __( 'You can place the button in a menu area. Go to', 'conveythis-translate' ); ?>
						<a href="<?php echo admin_url( 'nav-menus.php' ); ?>"><?php echo __( 'Appearance &gt; Menus', 'conveythis-translate' ); ?></a>
						<?php echo __( 'and drag and drop the ConveyThis Translate Custom link where you want.', 'conveythis-translate' ); ?>

				</div>
			</div>
			<div style="clear:both"></div>

			<!-- -->

			<h4><?php echo __( 'Picture', 'conveythis-translate' ); ?></h4>

			<div style="margin: 10px 0 28px 0; width: 550px;">
				<div style="float: left; width: 190px;">
					<p style="padding: 0; margin: 0;">
						<?php echo __( 'Select the display style for flags', 'conveythis-translate' ); ?>
					</p>
				</div>
				<div style="margin-left: 220px;">

							<div class="grouped fields">
								<div class="field">
									<div class="ui radio checkbox">
										<?php if( !empty( $this->style_flag ) && $this->style_flag == 'rect' ): ?>

											<input type="radio" name="style_flag" value="rect" checked="checked">

										<?php else: ?>

											<input type="radio" name="style_flag" value="rect">

										<?php endif; ?>
										<label><?php echo __( 'Rectangle flag', 'conveythis-translate' ); ?></label>
									</div>
								</div>
								<div class="field">
									<div class="ui radio checkbox">
										<?php if( !empty( $this->style_flag ) && $this->style_flag == 'sqr' ): ?>

											<input type="radio" name="style_flag" value="sqr" checked="checked">

										<?php else: ?>

											<input type="radio" name="style_flag" value="sqr">

										<?php endif; ?>
										<label><?php echo __( 'Square flag', 'conveythis-translate' ); ?></label>
									</div>
								</div>
								<div class="field">
									<div class="ui radio checkbox">
										<?php if( !empty( $this->style_flag ) && $this->style_flag == 'cir' ): ?>

											<input type="radio" name="style_flag" value="cir" checked="checked">

										<?php else: ?>

											<input type="radio" name="style_flag" value="cir">

										<?php endif; ?>
										<label><?php echo __( 'Circle flag', 'conveythis-translate' ); ?></label>
									</div>
								</div>
								<div class="field">
									<div class="ui radio checkbox">
										<?php if( !empty( $this->style_flag ) && $this->style_flag == 'without-flag' ): ?>

											<input type="radio" name="style_flag" value="without-flag" checked="checked">

										<?php else: ?>

											<input type="radio" name="style_flag" value="without-flag">

										<?php endif; ?>
										<label><?php echo __( 'Without flag', 'conveythis-translate' ); ?></label>
									</div>
								</div>
							</div>
				
				</div>
			</div>
			<div style="clear:both"></div>
		
			<!-- -->

			<h4><?php echo __( 'Text', 'conveythis-translate' ); ?></h4>

			<div style="margin: 10px 0 28px 0; width: 550px;">
				<div style="float: left; width: 190px;">
					<p style="padding: 0; margin: 0;">
						<?php echo __( 'Display the text name of the language', 'conveythis-translate' ); ?>
					</p>
				</div>
				<div style="margin-left: 220px;">

							<div class="grouped fields">
								<div class="field">
									<div class="ui radio checkbox">
										<?php if( !empty( $this->style_text ) && $this->style_text == 'full-text' ): ?>

											<input type="radio" name="style_text" value="full-text" checked="checked">

										<?php else: ?>

											<input type="radio" name="style_text" value="full-text">

										<?php endif; ?>
										<label><?php echo __( 'Full text', 'conveythis-translate' ); ?></label>
									</div>
								</div>
								<div class="field">
									<div class="ui radio checkbox">
										<?php if( !empty( $this->style_text ) && $this->style_text == 'short-text' ): ?>

											<input type="radio" name="style_text" value="short-text" checked="checked">

										<?php else: ?>

											<input type="radio" name="style_text" value="short-text">

										<?php endif; ?>
										<label><?php echo __( 'Short text', 'conveythis-translate' ); ?></label>
									</div>
								</div>
								<div class="field">
									<div class="ui radio checkbox">
										<?php if( !empty( $this->style_text ) && $this->style_text == 'without-text' ): ?>

											<input type="radio" name="style_text" value="without-text" checked="checked">

										<?php else: ?>

											<input type="radio" name="style_text" value="without-text">

										<?php endif; ?>
										<label><?php echo __( 'Without text', 'conveythis-translate' ); ?></label>
									</div>
								</div>
							</div>
				
				</div>
			</div>
			<div style="clear:both"></div>
		
			<!-- -->

			<h4><?php echo __( 'Position', 'conveythis-translate' ); ?></h4>

			<div style="margin: 10px 0 28px 0; width: 550px;">
				<div style="float: left; width: 190px;">
					<p style="padding: 0; margin: 0;">
						<?php echo __( 'Vertical location of the language selection button on the site', 'conveythis-translate' ); ?>
					</p>
				</div>
				<div style="margin-left: 220px;">

							<div class="grouped fields">
								<div class="field">
									<div class="ui radio checkbox">
										<?php if( !empty( $this->style_position_vertical ) && $this->style_position_vertical == 'top' ): ?>

											<input type="radio" name="style_position_vertical" value="top" checked="checked">

										<?php else: ?>

											<input type="radio" name="style_position_vertical" value="top">

										<?php endif; ?>
										<label><?php echo __( 'Top', 'conveythis-translate' ); ?></label>
									</div>
								</div>
								<div class="field">
									<div class="ui radio checkbox">
										<?php if( !empty( $this->style_position_vertical ) && $this->style_position_vertical == 'bottom' ): ?>

											<input type="radio" name="style_position_vertical" value="bottom" checked="checked">

										<?php else: ?>

											<input type="radio" name="style_position_vertical" value="bottom">

										<?php endif; ?>
										<label><?php echo __( 'Bottom', 'conveythis-translate' ); ?></label>
									</div>
								</div>
							</div>
				
				</div>
			</div>
			
			<div style="margin: 10px 0 28px 0; width: 550px;">
				<div style="float: left; width: 190px;">
					<p style="padding: 0; margin: 0;">
						<?php echo __( 'Horizontal location of the language selection button on the site', 'conveythis-translate' ); ?>
					</p>
				</div>
				<div style="margin-left: 220px;">

							<div class="grouped fields">
								<div class="field">
									<div class="ui radio checkbox">
										<?php if( !empty( $this->style_position_horizontal ) && $this->style_position_horizontal == 'left' ): ?>

											<input type="radio" name="style_position_horizontal" value="left" checked="checked">

										<?php else: ?>

											<input type="radio" name="style_position_horizontal" value="left">

										<?php endif; ?>
										<label><?php echo __( 'Left', 'conveythis-translate' ); ?></label>
									</div>
								</div>
								<div class="field">
									<div class="ui radio checkbox">
										<?php if( !empty( $this->style_position_horizontal ) && $this->style_position_horizontal == 'right' ): ?>

											<input type="radio" name="style_position_horizontal" value="right" checked="checked">

										<?php else: ?>

											<input type="radio" name="style_position_horizontal" value="right">

										<?php endif; ?>
										<label><?php echo __( 'Right', 'conveythis-translate' ); ?></label>
									</div>
								</div>
							</div>
				
				</div>
			</div>
			<div style="clear:both"></div>

			<!-- -->

			<h4><?php echo __( 'Indenting', 'conveythis-translate' ); ?></h4>

			<div style="margin: 10px 0 28px 0; width: 800px;">
				<div style="float: left; width: 190px;">
					<?php echo __( 'Vertical spacing from the top or bottom of the browser', 'conveythis-translate' ); ?>
				</div>
				<div style="margin-left: 220px;">

					<div style="float: left;">
						<input type="hidden" name="style_indenting_vertical" value="<?php echo $this->style_indenting_vertical; ?>">
						<span id="display-style-indenting-vertical"><?php echo $this->style_indenting_vertical; ?></span>px
					</div>
					<!-- Semantic -->
					<div class="ui grey range" style="margin-left: 36px;" id="range-style-indenting-vertical"></div>

				</div>
				<div style="clear:both"></div>
			</div>
			
			<div style="margin: 10px 0 28px 0; width: 800px;">
				<div style="float: left; width: 190px;">
					<?php echo __( 'Horizontal spacing from the top or bottom of the browser', 'conveythis-translate' ); ?>
				</div>
				<div style="margin-left: 220px;">

					<div style="float: left;">
						<input type="hidden" name="style_indenting_horizontal" value="<?php echo $this->style_indenting_horizontal; ?>">
						<span id="display-style-indenting-horizontal"><?php echo $this->style_indenting_horizontal; ?></span>px
					</div>
					<!-- Semantic -->
					<div class="ui grey range" style="margin-left: 36px;" id="range-style-indenting-horizontal"></div>

				</div>
				<div style="clear:both"></div>
			</div>
			<div style="clear:both"></div>

			<!-- -->

			<h4><?php echo __( 'Change flag', 'conveythis-translate' ); ?></h4>

			<!-- -->

			<div style="margin: 10px 0 28px 0; width: 800px;">
				<p style="padding: 0; margin: 0;">
					<?php echo __( 'By default all the languages have their flags in accordance with ISO standards. If you want to change the flag for one or several languages here you can customize this.', 'conveythis-translate' ); ?>
				</p>

				<?php $i = 0; ?>
				<?php while( $i < 5 ): ?>

				<div style="margin: 28px 0; width: 520px;">
					<div style="float: left; width: 250px;">

						<!-- Semantic -->
						<div class="ui fluid search selection dropdown">
							<input type="hidden" name="style_change_language[]" value="<?php echo $this->style_change_language[$i]; ?>">
							<i class="dropdown icon"></i>
							<div class="default text"><?php echo __( 'Select language', 'conveythis-translate' ); ?></div>
							<div class="menu">

								<?php foreach( $this->languages as $id => $language ): ?>

									<div class="item" data-value="<?php echo $id; ?>">
										<?php esc_html_e( $language['title'], 'conveythis-translate' ); ?>
									</div>

								<?php endforeach; ?>

							</div>
						</div>

					</div>
					<div style="float: left; width: 250px; margin-left: 20px;">

						<!-- Semantic -->
						<div class="ui fluid search selection dropdown">
							<input type="hidden" name="style_change_flag[]"  value="<?php echo $this->style_change_flag[$i]; ?>">
							<i class="dropdown icon"></i>
							<div class="default text"><?php echo __( 'Select Flag', 'conveythis-translate' ); ?></div>
							<div class="menu">

								<?php foreach( $this->flags as $flag ): ?>

									<div class="item" data-value="<?php echo esc_attr( $flag['code'] ); ?>">
										<div class="ui image" style="height: 28px; width: 42px; background-position: 50% 50%; background-repeat: no-repeat; background-image: url('//cdn.conveythis.com/images/flags/v2/rectangular/<?php echo $flag['code']; ?>.png')"></div>
										<?php esc_html_e( $flag['title'], 'conveythis-translate' ); ?>
									</div>

								<?php endforeach; ?>

							</div>
						</div>

					</div>
					<div style="margin-left: 540px;">
						<button class="conveythis-reset">X</button>
					</div>
				</div>

				<?php $i++; ?>
				<?php endwhile; ?>

			</div>

			<!-- -->

			<br>
			<h3><?php echo __( 'Block pages', 'conveythis-translate' ); ?></h3>
			
			<!-- -->

			<div style="margin: 10px 0 28px 0; width: 800px;">
				<p>
					<?php echo __( 'Add URL that you want to exclude from translations.', 'conveythis-translate' ); ?>
				</p>

				<textarea name="blockpages" style="width: 500px; height: 150px; white-space: nowrap; overflow-x: hidden;"><?php foreach( $this->blockpages as $blockpage ): ?><?php echo $blockpage . PHP_EOL; ?><?php endforeach; ?></textarea>

			</div>

			<!-- -->

		</div>
		<?php submit_button(); ?>
	</form>

	<p>
		<a href="https://wordpress.org/support/plugin/conveythis-translate/reviews/#postform" target="_blank"><?php echo __( 'Love ConveyThis? Give us 5 stars on WordPress.org', 'conveythis-translate' ); ?></a>
	</p>
	<p>
	<?php
		$message = __( 'If you need any help, you can contact us via our live chat at %swww.ConveyThis.com%s or email us at support@conveythis.com. You can also check our %sFAQ%s', 'conveythis-translate' );
		echo sprintf( $message, '<a href="https://www.conveythis.com/?utm_source=widget&utm_medium=wordpress" target="_blank">', '</a>', '<a href="https://www.conveythis.com/support/faq/?utm_source=widget&utm_medium=wordpress" target="_blank">', '</a>' );
	?>
	</p>
</div>

<link rel="stylesheet" href="<?php echo  plugins_url('conveythis-translate/css/dropdown.min.css'); ?>" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo  plugins_url('conveythis-translate/css/transition.min.css'); ?>" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo  plugins_url('conveythis-translate/css/range.css'); ?>" type="text/css" media="all">
<style>

	.ui.fluid.dropdown {
		width: initial;
	}

	.ui.dropdown .menu>.item {
		font-size: initial;
	}

	.ui.selection.dropdown {
		min-height: initial;
	}

	.ui.dropdown .delete.icon:before {
		cursor: pointer;
		content: 'x';
		font-style: initial;
		margin-left: 6px;
		color: #f7b4b4;
		line-height: 1.2em;
	}

	.conveythis-reset {
		border: none;
		color: red;
		padding: 2px 8px;
		border-radius: 3px;
		margin-top: 8px;
	}

	.conveythis-delete-page {
		border: none;
		color: red;
		padding: 2px 8px;
		border-radius: 3px;
	}

	#save-button {
		padding: 14px 35px;
		margin-top: 56px;
		text-transform: uppercase;
		font-weight: bold;
		color: #fff;
		background-color: steelblue;
		border: none;
		border-radius: 3px;
		cursor: pointer;
	}

	#customize-preview {
		position: absolute;
		right: 0;
		z-index: 1;
		width: 290px;
		background: #fff;
		padding: 0;
		border: none;
		border-radius: .28571429rem;
		-webkit-box-shadow: 0 1px 3px 0 #d4d4d5, 0 0 0 1px #d4d4d5;
		box-shadow: 0 1px 3px 0 #d4d4d5, 0 0 0 1px #d4d4d5;
		-webkit-transition: -webkit-box-shadow .1s ease,-webkit-transform .1s ease;
		transition: -webkit-box-shadow .1s ease,-webkit-transform .1s ease;
		transition: box-shadow .1s ease,transform .1s ease;
		transition: box-shadow .1s ease,transform .1s ease,-webkit-box-shadow .1s ease,-webkit-transform .1s ease;
	}

	.conveythis-input-text {
		padding : 8px;
		vertical-align: middle;
		width: 300px;
	}

</style>

<script src="<?php echo  plugins_url('conveythis-translate/js/jquery-3.3.1.min.js'); ?>"></script>
<script src="<?php echo  plugins_url('conveythis-translate/js/dropdown.min.js'); ?>"></script>
<script src="<?php echo  plugins_url('conveythis-translate/js/transition.min.js'); ?>"></script>
<script src="<?php echo  plugins_url('conveythis-translate/js/range.js'); ?>"></script>

<script src="<?php echo CONVEYTHIS_JAVASCRIPT_PLUGIN_URL; ?>/conveythis.js"></script>
<script src="<?php echo CONVEYTHIS_JAVASCRIPT_PLUGIN_URL; ?>/conveythis-view.js"></script>
<script>

	$(document).ready(function() {

		var cardOffset;
		var cardTop;

		$("#customize-preview").show("fast", function(){

			cardOffset = $("#customize-preview").offset();
			cardTop = $("#customize-preview").css( "top" );
		});

		$(document).scroll(function() {

			if( cardTop == $("#customize-preview").css( "top" ) ) {

				cardOffset = $("#customize-preview").offset();
			}

			if( ( cardOffset.top - 90 ) < $(this).scrollTop() ) {

				var top = $(this).scrollTop() - cardOffset.top + 90 + parseInt( cardTop, 10 );

				$("#customize-preview").css( "top", top + "px" );

			} else {

				$("#customize-preview").css( "top", "" );
			}
		});

		$("#customize-tab-toogle").click(function(e){
			e.preventDefault();
			$("#customize-tab-toogle").parent().hide();
			$("#customize-tab").slideToggle("slow");
		});

		$("#range-style-indenting-vertical").range({
			min: 0,
			max: 300,
			start: $("#display-style-indenting-vertical").text(),
			onChange: function(value) {
				$("#display-style-indenting-vertical").html( value );
				$("[name=style_indenting_vertical]").val( value );
			}
		});
		$("#range-style-indenting-horizontal").range({
			min: 0,
			max: 300,
			start: $("#display-style-indenting-horizontal").text(),
			onChange: function(value) {
				$("#display-style-indenting-horizontal").html( value );
				$("[name=style_indenting_horizontal]").val( value );
			}
		});
		
		//

		conveythis.effect(function(){
			$('#customize-view-button').transition('pulse');
		});
		conveythis.view();

		$('.ui.dropdown').dropdown({
			onChange: function() {
				conveythis.view();
			}
		});

		$('.conveythis-reset').on('click', function(e) {
			e.preventDefault();
			$(this).parent().parent().find('.ui.dropdown').dropdown('clear');
		});

	});

</script>
