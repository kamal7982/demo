
<?php
function custom_search_map($atts)
{
	ob_start();
?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
	<style>
		#map {
			height: 650px;
			width: 100%;
		}

		select {
			all: unset;
			border-bottom: 1px solid;
			background: url('https://www.charbase.com/images/glyph/9662') no-repeat right;
			background-size: 16px;
			width: 100%;
		}

		.waverlyAdvisor {
			background-color: #fff;
			width: 280px;
			padding: 30px;
			position: absolute;
			z-index: 999;
			top: 8%;
			left: 8%;
		}

		.waverlyAdvisor2 {
			background-color: #fff;
			width: 320px;
			padding: 30px 30px 35px 30px;
			position: absolute;
			z-index: 999;
			top: 8%;
			left: auto;
			right: 8%;
		}

		.leaflet-top.leaflet-left {
			display: none;
		}

		.tx {
			font-size: 26px;
		}

		.discreption,
		.location,
		.envelope,
		.phone {
			font-size: 16px;
			line-height: 22px;
		}
		.wave-btn{
			margin-top: 30px;
		}
		a.bttn {
			background-color: #83bcd3e8;
			border-radius: 2px;
			padding: 14px 18px;
			border: none;
			font-size: 16px;
			
			color: #ffffff;
		}
		.dot1,
		.dot2,
		.dot3 {
			color: #83bcd3e8;
			padding-right: 20px;
			font-size: 24px;
		}
		.location {
			padding-top: 80px;
		}
		.location,
		.envelope,
		.phone {
			display: flex;
			align-items: flex-start;
		}
		.phone-fa {
			margin-top: 8px;
			padding-top: 2px;
		}
		.leaflet-popup-content p {
			margin: 0 !important;
		}
		.location {
			padding-top: 20px!important;
		}
		.leaflet-popup-content .discreption, 
		.leaflet-popup-content .location, 
		.leaflet-popup-content .envelope,
		.leaflet-popup-content .phone {
			font-size: 14px !important;
			line-height: 18px;
		}
		.leaflet-popup-content .tx {
			font-size: 18px;
		}
		.leaflet-popup-content .dot1, 
		.leaflet-popup-content .dot2, 
		.leaflet-popup-content .dot3 {
			color: #83bcd3e8;
			padding-right: 20px;
			font-size: 18px;
		}
		.leaflet-popup-content .wave_cotent div {
			margin-bottom: 5px;
		}
	</style>
	<div class="waverlyAdvisor">
		<p>Find a <strong>Waverly Advisor<br />Near You</strong></p>
		<select id="countrySelect">
			<option value="0" data-cityname="">Select your city</option>
			<?php
			$args = array(
				'post_type' => 'search-on-map',
				'post_status' => 'publish',
				'posts_per_page' => -1,
				'orderby' => 'title',
				'order' => 'ASC',
			);

			$loop = new WP_Query($args);
			while ($loop->have_posts()) {
				$loop->the_post();
				$city_name = get_field('city_name');
				$description = get_field('description');
				$location_address = get_field('location_address');
				$phone = get_field('phone');
				$email = get_field('email');
				$button_link = get_field('button_link');				
				$cityname = explode(",", $city_name);
			?>
				<option data-cityname="<?php echo $city_name; ?>" data-desc="<?php echo $description; ?>" data-location="<?php echo $location_address; ?>" data-email="<?php echo $phone; ?>"  data-phone="<?php echo $email; ?>" value="<?php echo strtolower($cityname['0']); ?>"><?php echo $cityname['0']; ?></option>
			<?php
			}
			?>
		</select>
	</div>
	<div class="waverlyAdvisor2">
		<?php
		$df_city_name = 'austin';
		$args = array(
			'post_type' => 'search-on-map',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
			'meta_query' => array(
				array(
					'key' => 'city_name',
					'value' => 'austin',
					'compare' => 'LIKE'
				)
			)
		);

		$loop = new WP_Query($args);
		//print_r($loop);
		if ($loop->have_posts()) {
			while ($loop->have_posts()) {
				$loop->the_post();
				$city_name = get_field('city_name');
				$description = get_field('description');
				$location_address = get_field('location_address');
				$phone = get_field('phone');
				$email = get_field('email');
				$button_link = get_field('button_link');
		?>
				<div class="waver_content_wrapper">
					<p class="tx"><?php echo $city_name; ?></p>
					<p class="discreption"><?php echo $description; ?></p>
					<div class="wave_cotent">
						<div class="location">
							<i class="fa-solid dot1 fa-location-dot"></i>
							<p><?php echo $location_address; ?></p>
						</div>
						<div class="phone">
							<i class="fa-solid dot2 fa-phone"></i>
							<p class="phone-fa"><?php echo $phone; ?></p>
						</div>
						<div class="envelope">
							<i class="fa-solid dot3 fa-envelope"></i>
							<p mailto:class="phone-fa"><?php echo $email; ?></p>
						</div>
					</div>
					<div class="wave-btn">
						<a href="<?php echo $button_link; ?>" class="bttn">Meet The Team</a>
					</div>
				</div>
		<?php
			} //end of while loop
		} //end of if have post
		?>
	</div>
	<div id="map"></div>
	<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
	<script>
	
 		var defaultLatLng = [30.266666, -97.733330]; // Default center coordinates
        var defaultZoom = 6; // Default zoom level

        var map = L.map('map').setView(defaultLatLng, defaultZoom);
		
		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		}).addTo(map);
		
		var marker = L.marker(defaultLatLng).addTo(map);
		marker.setLatLng(defaultLatLng).bindPopup(
					`<div class="mapwrapp-tool">
						<p class="tx">Austin, TX</p><div class="wave_cotent">
						<div class="location">
							<i class="fa-solid dot1 fa-location-dot"></i>
							<p>8834 N Capital of Texas Hwy # 200 Austin, TX 78759 404-905-8235</p>
						</div>
						<div class="phone">
							<i class="fa-solid dot2 fa-phone"></i>
							<p class="phone-fa">404-905-8235</p>
						</div>
						<div class="envelope">
							<i class="fa-solid dot3 fa-envelope"></i>
							<p mailto:class="phone-fa">info@waverlyadvisors.com</p>
						</div>
					</div>`
					);	
		
		var countrySelect = document.getElementById('countrySelect');
		var popup = L.popup();
		
		countrySelect.addEventListener('change', function() {
			var selectedCountry = countrySelect.value;
 			var selected = jQuery(this).find('option:selected');
       		var cityname = selected.data('cityname');
			var location = selected.data('location'); 
			var email = selected.data('email'); 
			var phone = selected.data('phone'); 
			
			fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + selectedCountry)
				.then(response => response.json())
				.then(data => {
					var lat = parseFloat(data[0].lat);
					var lon = parseFloat(data[0].lon);
					map.setView([lat, lon], defaultZoom);
					marker.setLatLng([lat, lon]).bindPopup(
					`<div class="mapwrapp-tool">
						<p class="tx">${cityname}</p><div class="wave_cotent">
						<div class="location">
							<i class="fa-solid dot1 fa-location-dot"></i>
							<p>${location}</p>
						</div>
						<div class="phone">
							<i class="fa-solid dot2 fa-phone"></i>
							<p class="phone-fa">${phone}</p>
						</div>
						<div class="envelope">
							<i class="fa-solid dot3 fa-envelope"></i>
							<p mailto:class="phone-fa">${email}</p>
						</div>
					</div>`
					);						
				})
				.catch(error => console.error('Error:', error));
		});
		jQuery(document).ready(function($) {
			// jQuery code to handle the select box change event
			$('#countrySelect').change(function() {
				var selectedValue = $(this).val();
				
				var ajaxurl = '<?php echo admin_url('admin-ajax.php') ?>';
				var wp_nonce = '<?php echo wp_create_nonce( 'wp_rest' ) ?>';
				
				console.log(selectedValue);
				// Make AJAX request
				$.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {
						action: 'handle_select_change_search_map',
						selected_value: selectedValue,
						_wpnonce: wp_nonce
					},
					success: function(response) {
						$('.waver_content_wrapper').empty();
						$('.waver_content_wrapper').html(response);
					},
					error: function(xhr, status, error) {
						console.error(xhr.responseText);
					}
				});
			});
		});
	</script>
	<?php
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode('custom_search_map', 'custom_search_map');

/*
function handle_select_change_search_map()
{
	$df_city_name = $_POST['selected_value'];
	$args = array(
		'post_type' => 'search-on-map',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC',
		'meta_query' => array(
			array(
				'key' => 'city_name',
				'value' => $df_city_name,
				'compare' => 'LIKE'
			)
		)
	);

	$loop = new WP_Query($args);
	if ($loop->have_posts()) {
		while ($loop->have_posts()) {
			$loop->the_post();
			$city_name = get_field('city_name');
			$description = get_field('description');
			$location_address = get_field('location_address');
			$phone = get_field('phone');
			$email = get_field('email');
			$button_link = get_field('button_link');
	?>
							<div class="waver_content_wrapper">
					<p class="tx"><?php echo $city_name; ?></p>
					<p class="discreption"><?php echo $description; ?></p>
					<div class="wave_cotent">
						<div class="location">
							<i class="fa-solid dot1 fa-location-dot"></i>
							<p><?php echo $location_address; ?></p>
						</div>
						<div class="phone">
							<i class="fa-solid dot2 fa-phone"></i>
							<p class="phone-fa"><?php echo $phone; ?></p>
						</div>
						<div class="envelope">
							<i class="fa-solid dot3 fa-envelope"></i>
							<p mailto:class="phone-fa"><?php echo $email; ?></p>
						</div>
					</div>
					<div class="wave-btn">
						<a href="<?php echo $button_link; ?>" class="bttn">Meet The Team</a>
					</div>
				</div>
<?php
		} //end of while loop
	} //end of if have post
    wp_die();
}
add_action('wp_ajax_nopriv_handle_select_change_search_map', 'handle_select_change_search_map');
add_action('wp_ajax_handle_select_change_search_map', 'handle_select_change_search_map');

*/
