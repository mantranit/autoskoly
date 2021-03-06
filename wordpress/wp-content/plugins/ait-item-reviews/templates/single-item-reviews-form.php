{var $review_questions = AitItemReviews::getReviewQuestions($post->id)}
{var $ratingsDisplayed = AitItemReviews::hasReviewQuestions($post->id, $review_questions)}
{var $ratingsDisplayedClass = $ratingsDisplayed ? 'ratings-shown' : 'ratings-hidden'}
{var $username = !is_user_logged_in() ? 'Anonymous' : 'Administrator'}

<div class="reviews-form-container {$ratingsDisplayedClass}">
	<div class="content">
		<div class="review-details" style="display: none;">
			<div class="review-detail">
				<input type="hidden" name="rating-for" value="{$post->id}">
				{!= wp_nonce_field( 'ajax-nonce_'.$post->id )}
			</div>

			<div class="review-detail">
				<input type="text" id="rating-name" name="rating-name" placeholder="<?php _e('Your Name', 'ait-item-reviews') ?>" value="{$username}">
			</div>
			<div class="review-detail">
				<textarea id="rating-desc" name="rating-desc" placeholder="<?php _e('Description', 'ait-item-reviews') ?>" rows="3"></textarea>
			</div>
		</div>
		
		{if $ratingsDisplayed}
		<div class="review-ratings">
			{if $review_questions['question1']}
			<div class="review-rating" data-rating-id="1">
				<span class="review-rating-question">
					{$review_questions['question1']}
				</span>
				<span class="review-rating-stars"></span>
				<span class="review-rated-stars"></span>
			</div>
			{/if}
			
			{if $review_questions['question2']}
			<div class="review-rating" data-rating-id="2">
				<span class="review-rating-question">
					{$review_questions['question2']}
				</span>
				<span class="review-rating-stars"></span>
			</div>
			{/if}
			
			{if $review_questions['question3']}
			<div class="review-rating" data-rating-id="3">
				<span class="review-rating-question">
					{$review_questions['question3']}
				</span>
				<span class="review-rating-stars"></span>
			</div>
			{/if}
			
			{if $review_questions['question4']}
			<div class="review-rating" data-rating-id="4">
				<span class="review-rating-question">
					{$review_questions['question4']}
				</span>
				<span class="review-rating-stars"></span>
			</div>
			{/if}
			
			{if $review_questions['question5']}
			<div class="review-rating" data-rating-id="5">
				<span class="review-rating-question">
					{$review_questions['question5']}
				</span>
				<span class="review-rating-stars"></span>
			</div>
			{/if}
		</div>
		{/if}
		<div class="review-actions" style="display: none;">
			<button id="send-rating" type="button" class="ait-sc-button" data-text="<?php _e('Send Rating', 'ait-item-reviews') ?>"><?php _e('Send Rating', 'ait-item-reviews') ?></button>
		</div>
		<div class="review-notifications">
			<div class="review-notification review-notification-sending ait-sc-notification info"><?php _e('Publishing ...', 'ait-item-reviews') ?></div>
			<div class="review-notification review-notification-success ait-sc-notification success"><?php _e('Vaše hodnotenie bolo úspešne odoslané', 'ait-item-reviews') ?></div>
			<div class="review-notification review-notification-error ait-sc-notification error"><?php _e('Please fill out all fields', 'ait-item-reviews') ?></div>
		</div>
		<script type="text/javascript">
		jQuery(document).ready(function(){
			function disableRating(rated) {
				jQuery('.review-rating-stars').hide();
				var ratedHtml = jQuery('.review-rated-stars');
				for(var i = 0; i < rated; i++){
					ratedHtml.append('<i class="fa fa-star"></i>');
				}
				for(; i < 5; i++){
					ratedHtml.append('<i class="fa fa-star-o"></i>');
				}
			}
			var rated = parseInt(getCookie("rated"), 10);
			if(rated > 0){
				disableRating(rated);
			}

			jQuery('.reviews-form-container').on('click', '.review-rating-stars i', function(){
				var rated = getCookie("rated");
				if (rated === "") {
					var that = jQuery(this);
					rated = that.index() + 1;
					jQuery('#rating-desc').val(that.attr('title'));
					jQuery('#send-rating:not(.disabled)').trigger('click').addClass('disabled');

					jQuery('.reviews-form-container').off('click', '.review-rating-stars i');
					setCookie("rated", rated, 0.25/24, window.location.pathname);

					disableRating(rated);
				}
			});
			// form submit function
			jQuery('.review-actions button').on('click', function(e){
				e.preventDefault();
				jQuery('.review-notifications .review-notification').hide();

				var ajaxData = {};
				var ratings = [];
				var validationCounter = 0;
				// data fields
				var $toCheck = jQuery('.review-details input[type=hidden], .review-details input[type=text], .review-details textarea, .reviews-form-container .review-rating input[type=hidden]');

				$toCheck.each(function(){
					if(jQuery(this).val()){
						// okey
						var name = jQuery(this).attr('name');
						if(name == 'score'){
							var rating = {
								question: jQuery(this).parent().parent().find('.review-rating-question').length > 0 ? jQuery(this).parent().parent().find('.review-rating-question').html().trim() : "",
								value: jQuery(this).val()
							}
							ratings.push(rating);
						} else {
							ajaxData[name] = jQuery(this).val();
						}
						validationCounter = validationCounter + 1;
					} else {
						// empty input -> not a valid form
						return false;
					}
				});
				ajaxData['rating-values'] = ratings;

				if(validationCounter == $toCheck.length){
					// send through ajax
					var params = {
						'action': 'publishReview',
						'data': ajaxData
					};

					jQuery.ajax({
						type: "POST",
						url: ait.ajax.url,
						data: params,
						beforeSend: function(){
							// disable sending
							jQuery('.review-actions button').css('width', jQuery('.review-actions button').outerWidth()).attr('disabled', true);
							// show waiting / loading
							jQuery('.review-notifications .review-notification-sending').show();
						},
						success: function(){
							// hide waiting / loading
							jQuery('.review-notifications .review-notification-sending').hide();
							// show notification
							jQuery('.review-notifications .review-notification-success').show().delay(2500).fadeOut();
							// reset form
							//jQuery('.review-details input[type=text], .review-details textarea').val("");
							//jQuery('.reviews-form-container .review-ratings .review-rating-stars').raty('reload');
							// enable sending
							//jQuery('.review-actions button').removeAttr('disabled');
							setTimeout(function(){
								jQuery('.review-actions button').removeAttr('style')
							}, 600);
						},
					});
				} else {
					// not all fields are filled
					jQuery('.review-notifications .review-notification-error').show().delay(2500).fadeOut();
				}

			});
		});
		</script>
	</div>
</div>