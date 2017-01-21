{* VARIABLES *}
{var $concreteTaxonomy = isset($taxonomy) && $taxonomy != "" ? $taxonomy : ''}
{var $maxCategories = $options->theme->items->maxDisplayedCategories}
{* VARIABLES *}


	{if !$wp->isSingular}

		{if $wp->isSearch}
			{var $isAdvanced = false}

			{if isset($_REQUEST['a']) && $_REQUEST['a'] != ""}
				{var $isAdvanced = true}
			{/if}

			{if $isAdvanced}
				{var $noFeatured = $options->theme->item->noFeatured}

				{var $categories = get_the_terms($post->id, 'ait-items')}
				{var $categories_featured = array()}
				{var $categories_nofeatured = array()}

				{if is_array($categories) && count($categories) > 0}
					{foreach $categories as $category}
						{var $cat_meta = get_option($category->taxonomy . "_category_" . $category->term_id)}
						{if isset($cat_meta['category_featured'])}
							{? array_push($categories_featured, $category)}
						{else}
							{? array_push($categories_nofeatured, $category)}
						{/if}
					{/foreach}
					{var $categories = array_merge($categories_featured, $categories_nofeatured)}
				{/if}

				{var $meta = $post->meta('item-data')}

				{var $dbFeatured = get_post_meta($post->id, '_ait-item_item-featured', true)}
				{var $isFeatured = $dbFeatured != "" ? filter_var($dbFeatured, FILTER_VALIDATE_BOOLEAN) : false}

				<div n:class='item-container, $isFeatured ? item-featured, defined("AIT_REVIEWS_ENABLED") ? reviews-enabled'>
						<div class="content">

							<div class="item-image">
								<a class="main-link" href="{$post->permalink}">
									<span>{__ 'Otvoriť'}</span>
									{if $post->image}
										<img src="{imageUrl $post->imageUrl, width => 200, height => 240, crop => 1}" alt="Featured">
										{else}
										<img src="{imageUrl $noFeatured, width => 200, height => 240, crop => 1}" alt="Featured">
									{/if}
								</a>
								{if defined('AIT_REVIEWS_ENABLED')}
									{includePart "portal/parts/carousel-reviews-stars", item => $post, showCount => false}
								{/if}
							</div>
							<div class="item-data">
								<div class="item-header">
									<div class="item-title-wrap">
										<div class="item-title">
											<a href="{$post->permalink}">
												<h3>{!$post->title}</h3>
											</a>
										</div>
										<span class="subtitle">{AitLangs::getCurrentLocaleText($meta->subtitle)}</span>
									</div>

									{var $target = $meta->socialIconsOpenInNewWindow ? 'target="_blank"' : ""}
									{if $meta->displaySocialIcons}

											<div class="social-icons-container">
												<div class="content">
													{if count($meta->socialIcons) > 0}
														<ul><!--
														{foreach $meta->socialIcons as $icon}
														--><li>
																<a href="{!$icon['link']}" {!$target}>
																	<i class="fa {$icon['icon']}"></i>
																</a>
															</li><!--
														{/foreach}
														--></ul>
													{/if}
												</div>
											</div>

									{/if}

									{if is_array($categories) && count($categories) > 0}
										<div class="item-categories">
											{foreach $categories as $category}
												{var $catLink = get_term_link($category)}
												<a href="{$catLink}"><span class="item-category">{!$category->name}</span></a>
											{/foreach}
											{var $terms = get_the_terms($post->id, 'ait-locations')}
											{foreach $terms as $index => $category}
												{var $catLink = get_term_link($category)}
												<a href="{$catLink}"><span class="item-category">{!$category->name}</span></a>
											{/foreach}
										</div>
									{/if}
								</div>
								<div class="item-body">
									<div class="entry-content">
										<p>
										{if $post->hasExcerpt}
											{!$post->excerpt|striptags|trim|truncate: 140}
										{else}
											{!$post->content|striptags|trim|truncate: 250}
										{/if}
										</p>
									</div>
								</div>
								<div class="item-footer">
									<div class="item-address">
										<span class="label">{__ 'Lokalita'}:</span>
										<span class="value">
											{var $terms = get_the_terms($post->id, 'ait-items')}
											{foreach $terms as $index => $term}
												<span>{$term->name}</span>,
											{/foreach}

											{var $terms = get_the_terms($post->id, 'ait-locations')}
											{foreach $terms as $index => $term}
												{if $index > 0}, {/if}<span>{$term->name}</span>
											{/foreach}
										</span>
									</div>

									{if $meta->languagesOffered}
									<div class="item-web">
										<span class="label">{__ 'Výuka v jazykoch'}:</span>
										<span class="value">{$meta->languagesOffered}</span>
									</div>
									{/if}

									{var $licences = array()}

									{if defined('AIT_ADVANCED_FILTERS_ENABLED')}
										{var $item_meta_filters = $post->meta('filters-options')}
										{if is_array($item_meta_filters->filters) && count($item_meta_filters->filters) > 0}
											{var $custom_features = array()}
											{foreach $item_meta_filters->filters as $filter_id}
												{var $filter_data = get_term($filter_id, 'ait-items_filters', "OBJECT")}
												{if $filter_data}
													{var $filter_meta = get_option( "ait-items_filters_category_".$filter_data->term_id )}
													{var $filter_icon = isset($filter_meta['icon']) ? $filter_meta['icon'] : ""}
													{? array_push($licences, $filter_data->name)}
												{/if}
											{/foreach}
										{/if}
									{/if}


									{if is_array($licences) && count($licences) > 0}
									<div class="item-features">
										<div class="label">{__ 'Typy vodičákov'}:</div>
										<div class="value">
											<ul class="item-filters">
											{foreach $licences as $filter}

												<li class="item-filter">
													<span class="filter-hover">
														{!$filter}
													</span>

												</li>
											{/foreach}
											</ul>
										</div>
									</div>
									{/if}


								</div>
							</div>
						</div>


				</div>

			{else}
				{*** SEARCH RESULTS ONLY ***}

				<article {!$post->htmlId} {!$post->htmlClass('hentry')}>
					<header class="entry-header">

						<div class="entry-title">

							<div class="entry-title-wrap">
								{includePart parts/entry-date-format, dateIcon => $post->rawDate, dateLinks => 'no', dateShort => 'no'}
								<h2><a href="{$post->permalink}">{!$post->title}</a></h2>
								{if $post->type == post}
									{includePart parts/entry-author}
								{/if}
							</div><!-- /.entry-title-wrap -->
						</div><!-- /.entry-title -->
					</header><!-- /.entry-header -->

					<div class="entry-content loop">
						{!$post->excerpt}
						<a href="{$post->permalink}" class="more">{!__ 'read more'}</a>
					</div><!-- .entry-content -->

<!-- 					<footer class="entry-footer">
							{if $concreteTaxonomy}
								{includePart parts/entry-categories, taxonomy => $concreteTaxonomy}
							{else}
								{if $post->isInAnyCategory}
									{includePart parts/entry-categories, taxonomy => $concreteTaxonomy}
								{/if}
							{/if}
					</footer> --><!-- /.entry-footer -->
				</article>
			{/if}

		{else}

			{*** STANDARD LOOP ***}

			<article {!$post->htmlId} n:class="hentry , $post->htmlClass('', false), !$post->hasImage ? has-no-thumbnail">
				<div class="entry-wrap">
					<header class="entry-header {if !$post->hasImage}nothumbnail{/if}">

						<div class="entry-thumbnail-desc">

							{includePart parts/entry-date-format, dateIcon => $post->rawDate, dateLinks => 'no', dateShort => 'yes'}

							<div class="entry-title">
								<div class="entry-title-wrap">
									<h2><a href="{$post->permalink}">{!$post->title}</a></h2>
								</div><!-- /.entry-title-wrap -->
							</div><!-- /.entry-title -->

							{if $post->hasImage}
								<div class="more-wrap">
									<a href="{$post->permalink}" class="more">{!__ 'read more'}</a>
								</div>
							{/if}

						</div>

						{if $post->hasImage}
							<div class="entry-thumbnail">
								<div class="entry-thumbnail-wrap entry-content" style="background-image: url('{imageUrl $post->imageUrl, width => 1000, height => 350, crop => 1}')"></div>
							</div>
						{/if}

						<div class="entry-meta">
							{if $post->isSticky and !$wp->isPaged and $wp->isHome}
								<span class="featured-post">{__ 'Featured post'}</span>
							{/if}

							{capture $editLinkLabel}<span class="edit-link">{!__ 'Edit'}</span>{/capture}
	      					{!$post->editLink($editLinkLabel)}
						</div>

					</header><!-- /.entry-header -->

					<footer class="entry-footer">
						<div class="entry-data">

							{if $post->type == post}
								{includePart parts/entry-author}
							{/if}

							{if $post->isInAnyCategory}
								{includePart parts/entry-categories}
							{/if}

							{includePart parts/comments-link}

						</div>
					</footer><!-- .entry-footer -->
				</div>

				<div class="entry-content loop">
					{if $post->hasContent}
						{!$post->excerpt}
					{else}
						{!$post->content}
					{/if}

					{if !$post->hasImage}
						<div class="more-wrap no-thumbnail">
							<a href="{$post->permalink}" class="more">{!__ 'read more'}</a>
						</div>
					{/if}

				</div><!-- .entry-content -->

			</article>
		{/if}

	{else}

		{*** POST DETAIL ***}

		<article {!$post->htmlId} class="content-block hentry">

			<div class="entry-title hidden-tag">
				<h2>{!$post->title}</h2>
			</div>

			<div class="entry-thumbnail">
					{if $post->hasImage}
						<div class="entry-thumbnail-wrap">
						{includePart parts/comments-link}
						 <a href="{$post->imageUrl}" class="thumb-link">
						  <span class="entry-thumbnail-icon">
							<img src="{imageUrl $post->imageUrl, width => 1000, height => 400, crop => 1}" alt="{!$post->title}">
						  </span>
						 </a>
						</div>
					{/if}
				</div>

			<div class="entry-content">
				{!$post->content}
				{!$post->linkPages}
			</div><!-- .entry-content -->

			<footer class="entry-footer single">

				{if $post->categoryList}
					{includePart parts/entry-categories, taxonomy => 'category'}
				{/if}

				{if $post->tagList}
					<span class="tags">
						<span class="tags-links">{!$post->tagList}</span>
					</span>
				{/if}


			</footer><!-- .entry-footer -->

			{*includePart parts/author-bio*}


		</article>

	{/if}
