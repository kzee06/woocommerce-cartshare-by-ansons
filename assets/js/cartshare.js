jQuery(document).ready(function($) {
	$('#cartshare-share-cart-button').on('click', function() {
		$('#cartshare-share-cart-modal').show();
	});

	$('.cartshare-close').on('click', function() {
		$('#cartshare-share-cart-modal').hide();
	});

	$('#cartshare-share-cart-form').on('submit', function(e) {
		e.preventDefault();

		var data = {
			action: 'cartshare_share_cart',
			nonce: cartshare.nonce,
			customer_phone: $('#cartshare-customer-phone').val(),
			branch: $('#cartshare-branch').val()
		};

		$.post(cartshare.ajax_url, data, function(response) {
			if (response.success) {
				$('#cartshare-share-cart-result').html('<p>' + response.data + '</p>');
				$('#cartshare-share-cart-form')[0].reset();
			} else {
				$('#cartshare-share-cart-result').html('<p>' + response.data + '</p>');
			}
		});
	});
});
