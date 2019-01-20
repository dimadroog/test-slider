<div id="test_slider_plugin">
	<?php if (!get_option('test_slider_setting')): ?>
		<p><?php echo  __('No slides yet. Аdd photos with admin panel', 'test_slider') ?></p>
	<?php else: ?>			
	    <div class="test-slider-wrap">
			<div class="lSAction">
				<a id="goToPrevSlide" class="lSPrev"></a>
				<a id="goToNextSlide" class="lSNext"></a>
			</div>
	    <ul id="test-slider" class="test-slider">
	    	<?php foreach (get_option('test_slider_setting') as $key => $value): ?>
		        <li class="test-slider-item">
					<div class="row">
						<div class="col-md-5 col-xs-12 test-slider-options">
			            	<h2><?php echo ($value['title'])?$value['title']:'&nbsp;'; ?></h2>
			            	<?php if ($value['customer']): ?>
				            	<div class="row test-slider-option-row">
				            		<div class="col-md-3 col-sm-2">
				            			<span class="test-slider-option-label">
				            				<?php echo  __('Customer', 'test_slider') ?>:
				            			</span>
				            		</div>
				            		<div class="col-md-9 col-sm-10 ">
				            			<span class="test-slider-option-value">
				            				<?php echo $value['customer']; ?>
				            			</span>
				            		</div>
				            	</div>
			            	<?php endif ?>
			            	<?php if ($value['tasks']): ?>
				            	<div class="row test-slider-option-row">
				            		<div class="col-md-3 col-sm-2">
				            			<span class="test-slider-option-label">
				            				<?php echo  __('Tasks', 'test_slider') ?>:
				            			</span>
				            		</div>
				            		<div class="col-md-9 col-sm-10 ">
				            			<span class="test-slider-option-value">
				            				<?php echo $value['tasks']; ?>
				            			</span>
				            		</div>
				            	</div>
			            	<?php endif ?>
			            	<?php if ($value['done']): ?>
				            	<div class="row test-slider-option-row">
				            		<div class="col-md-3 col-sm-2">
				            			<span class="test-slider-option-label">
				            				<?php echo  __('Done', 'test_slider') ?>:
				            			</span>
				            		</div>
				            		<div class="col-md-9 col-sm-10 ">
				            			<span class="test-slider-option-value">
				            				<?php echo $value['done']; ?>
				            			</span>
				            		</div>
				            	</div>
			            	<?php endif ?>
						</div>
						<div class="col-md-7 col-xs-12">
							<img src="<?php echo wp_get_attachment_url( $value['img']); ?>">
						</div>						

					</div>
		        </li>
	    	<?php endforeach ?>
	    </ul>
	    </div>
	<?php endif ?>
</div>