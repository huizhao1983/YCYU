<?php

class Favorites_Plugins {
	public static $instance = null;

	static function get_instance() {
		if ( null == Favorites_Plugins::$instance ) {
			Favorites_Plugins::$instance = new Favorites_Plugins();
		}

		return Favorites_Plugins::$instance;
	}

	function render_page() {
		Favorites_Extension::validate_favories( 'plugin' );
		?>
		<div class="ui alt segment" id="mainwp-favorite-plugins">
			<div class="mainwp-main-content">
				<div class="ui labeled icon inverted menu mainwp-sub-submenu" id="mainwp-favorite-plugins-menu">
					<a href="#" class="item" data-tab="mainwp-favorite-plugins-tab"><i class="plug icon"></i> <?php _e( 'Favorite Plugins', 'mainwp-favorites-extension' ); ?></a>
					<a href="#" class="item" data-tab="mainwp-favorite-plugin-groups-tab"><i class="folder icon"></i> <?php _e( 'Favorite Plugins Groups', 'mainwp-favorites-extension' ); ?></a>
				</div>
				<div class="ui message" id="mainwp-message-zone" style="display:none"></div>
				<div class="ui segment active tab" data-tab="mainwp-favorite-plugins-tab">
					<table class="ui tablet stackable table" id="mainwp-favorite-plugins-table">
						<thead>
              <tr>
								<th class="check-column collapsing no-sort"><span class="ui checkbox"><input type="checkbox"></span></th>
								<th><?php echo __( 'Plugin', 'mainwp-favorites-extension' ); ?></th>
								<th><?php echo __( 'Version', 'mainwp-favorites-extension' ); ?></th>
								<th><?php echo __( 'Author', 'mainwp-favorites-extension' ); ?></th>
								<th class="collapsing no-sort"><i class="sticky note outline icon"></i></th>
							</tr>
						</thead>
						<tbody>
							<?php $this->get_table_content() ; ?>
						</tbody>
					</table>
				</div>
				<div class="ui segment tab" data-tab="mainwp-favorite-plugin-groups-tab">
					<table class="ui tablet stackable table" id="mainwp-favorite-plugin-groups-table">
						<thead>
							<tr>
								<th class="check-column collapsing no-sort"><span class="ui checkbox"><input type="checkbox"></span></th>
								<th><?php echo __( 'Plugins Group', 'mainwp-favorites-extension' ); ?></th>
								<th><?php echo __( 'Number of Plugins', 'mainwp-favorites-extension' ); ?></th>
								<th class="collapsing no-sort"><i class="sticky note outline icon"></i></th>
							</tr>
						</thead>
						<tbody>
              <?php $this->get_table_groups_content(); ?>
            </tbody>
					</table>
				</div>

			</div>
			<div class="mainwp-side-content mainwp-no-padding">
				<div class="mainwp-select-sites">
					<h3 class="header"><?php _e( 'Select Sites', 'mainwp-favorites-extension' ); ?></h3>
					<?php do_action( 'mainwp_select_sites_box' ); ?>
				</div>
				<div class="ui divider"></div>
				<div class="mainwp-search-options">
					<div class="ui header"><?php _e( 'Installation Options', 'mainwp-favorites-extension' ); ?></div>
          <div class="ui form">
            <div class="field">
              <div class="ui toggle checkbox" data-tooltip="<?php esc_attr_e( 'If enabled, the plugin(s) will be automatically activated after the installation.', 'mainwp-favorites-extension' ); ?>" data-position="left center" data-inverted="">
                <input type="checkbox" value="1" checked="checked" id="chk_activate_plugin">
                <label for="chk_activate_plugin"><?php _e( 'Activate after installation', 'mainwp-favorites-extension' ); ?></label>
              </div>
            </div>
            <div class="field">
              <div class="ui toggle checkbox" data-tooltip="<?php esc_attr_e( 'If enabled and the plugins already installed on the sites, the already installed version will be overwritten.', 'mainwp-favorites-extension' ); ?>" data-position="left center" data-inverted="">
                <input type="checkbox" value="2" checked="checked" id="chk_overwrite">
                <label for="chk_overwrite"><?php _e( 'Overwrite existing version', 'mainwp-favorites-extension' ); ?></label>
              </div>
            </div>
          </div>
        </div>
				<div class="ui divider"></div>
				<div class="mainwp-search-submit">
                                    <input type="button" value="<?php esc_attr_e( 'Complete Installation', 'mainwp-favorites-extension' ); ?>" class="ui green big fluid button" onclick="mainwp_favorite_bulk_install('plugin'); return false;" id="mainwp-favorite-plugin-bulk-install" name="mainwp-favorite-plugin-bulk-install">
				</div>
			</div>
			<div class="ui clearing hidden divider"></div>
		</div>

		<script type="text/javascript">
		jQuery( '#mainwp-favorite-plugins .ui.table' ).DataTable( {
			"searching": true,
			"paging" : false,
			"info" : true,
			"columnDefs": [ { "orderable": false, "targets": "no-sort" } ],
			"order": [ [ 1, "asc" ] ],
			"language" : { "emptyTable": "No favorites added. Go to the extension page to add Favorite Plugins." }
		} );
		</script>

		<div id="mainwp-notes" class="ui modal">
		  <div class="header"><?php esc_html_e( 'Notes', 'mainwp' ); ?></div>
		  <div class="content" id="mainwp-notes-content">
				<div id="mainwp-notes-html"></div>
				<div id="mainwp-notes-editor" class="ui form" style="display:none;">
					<div class="field">
						<label><?php esc_html_e( 'Edit note', 'mainwp' ); ?></label>
						<textarea id="mainwp-notes-note"></textarea>
					</div>
					<div><?php _e( 'Allowed HTML tags:', 'mainwp' ); ?> &lt;p&gt;, &lt;strong&gt;, &lt;em&gt;, &lt;br&gt;, &lt;hr&gt;, &lt;a&gt;, &lt;ul&gt;, &lt;ol&gt;, &lt;li&gt;, &lt;h1&gt;, &lt;h2&gt; </div>
				</div>
		  </div>
			<div class="actions">
				<div class="ui grid">
				  <div class="eight wide left aligned middle aligned column">
						<div id="mainwp-notes-status" class="left aligned"></div>
					</div>
				  <div class="eight wide column">
						<form>
							<input type="button" class="ui green button" id="mainwp-notes-save" value="<?php esc_attr_e( 'Save note', 'mainwp' ); ?>" style="display:none;"/>
							<input type="button" class="ui basic green button" id="mainwp-notes-edit" value="<?php esc_attr_e( 'Edit', 'mainwp' ); ?>"/>
							<input type="button" class="ui red button" id="mainwp-notes-cancel" value="<?php esc_attr_e( 'Close', 'mainwp' ); ?>"/>
							<input type="hidden" id="mainwp-notes-favroriteid" value=""/>
							<input type="hidden" id="mainwp-notes-type" value=""/>
						</form>
					</div>
				</div>
		  </div>
		</div>
		<script type="text/javascript">jQuery( '#mainwp-favorite-plugins-menu .item' ).tab();</script>
		<script>
			jQuery(document).ready(function () {
//				favorites_install_set_install_links();
//				group_install_set_install_links();
			});
		</script>
		<?php
                Favorites_Plugins::gen_install_modal();
	}

        public static function gen_install_modal() {
            ?>
            <div class="ui modal" id="favorites-bulk-install-modal">
                   <div class="header">Installing</div>
                   <div class="scrolling content">

                   </div>
                   <div class="actions">
                           <div class="ui cancel button">Close</div>
                   </div>
           </div>
            <?php
        }

	public function get_table_content() {
		$favorites = Favorites_Extension_DB::get_instance()->query( Favorites_Extension_DB::get_instance()->get_sql_favorites_for_current_user( 'plugin', false ) );

		while ( $favorites && ( $favorite = @Favorites_Extension_DB::fetch_object( $favorites ) ) ) {

			$download_url = ! empty( $favorite->file ) ? Favorites_Extension::get_instance()->getFavoritesDownloadUrl( 'plugins', $favorite->file ) : '';
			?>
			<tr id="fav-<?php echo $favorite->id; ?>" favorite_slug="<?php echo $favorite->slug; ?>" favorite_id="<?php echo rawurlencode( $favorite->id ); ?>" favorite_name="<?php echo urlencode( $favorite->name ); ?>" download_url="<?php echo $download_url; ?>">
				<td class="check-column"><span class="ui checkbox"><input type="checkbox" value="<?php echo base64_encode( $favorite->id ); ?>" id="<?php echo $favorite->id; ?>"></span></td>
				<td>
					<?php if ( !empty( $favorite->url ) ) : ?>
					<a href="<?php echo $favorite->url; ?>" target="_blank">
						<?php echo $favorite->name; ?>
					</a>
					<?php else : ?>
						<?php echo $favorite->name; ?>
					<?php endif; ?>
				</td>
				<td><?php echo $favorite->version; ?></td>
				<td><?php echo $favorite->author; ?></td>
				<td class="center aligned">
					<?php if ( $favorite->note == '' ) : ?>
					<a href="#" id="mainwp-favorite-notes-<?php echo $favorite->id; ?>" class="mainwp-edit-favorite-note" type="favorite"><i class="sticky note outline icon"></i></a>
					<?php else : ?>
					<a href="#" id="mainwp-favorite-notes-<?php echo $favorite->id; ?>" class="mainwp-edit-favorite-note" type="favorite"><i class="sticky note icon"></i></a>
					<?php endif; ?>
					<span style="display:none" id="mainwp-favorite-notes-<?php echo $favorite->id; ?>-note"><?php echo $favorite->note; ?></span>
				</td>
			</tr>
			<?php
		}
	}

	public function get_table_groups_content() {
		$groups = Favorites_Extension_DB::get_instance()->get_groups( 'plugin', true );
		foreach ( $groups as $group ) {
			$nrfavs = substr_count( $group->favorites, ',' ) + 1;
			if ( $nrfavs == 1 ) {
				$nrfavs = 0;
			}
			?>
			<tr id="group-<?php echo $group->id; ?>" group_id="<?php echo rawurlencode( $group->id ); ?>" group_name="<?php echo urlencode( $group->name ); ?>">
				<td class="check-column"><span class="ui checkbox"><input type="checkbox" value="<?php echo base64_encode( $group->id ); ?>" id="<?php echo $group->id; ?>"></span></td>
				<td><?php echo stripslashes( $group->name ); ?></td>
				<td class="ui mini"><span data-tooltip="<?php echo $group->favorites; ?>" data-inverted=""><?php echo $nrfavs; ?></span></td>
				<td class="center aligned">
					<?php if ( $group->note == '' ) : ?>
					<a href="#" id="mainwp-favorite-notes-<?php echo $group->id; ?>" class="mainwp-edit-favorite-note" type="group"><i class="sticky note outline icon"></i></a>
					<?php else : ?>
					<a href="#" id="mainwp-favorite-notes-<?php echo $group->id; ?>" class="mainwp-edit-favorite-note" type="group"><i class="sticky note icon"></i></a>
					<?php endif; ?>
					<span style="display:none" id="mainwp-favorite-notes-<?php echo $group->id; ?>-note"><?php echo $group->note; ?></span>
				</td>
			</tr>
			<?php
		}
	}
}

?>
