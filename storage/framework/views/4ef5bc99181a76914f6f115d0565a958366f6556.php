<div class="boardBox">
    <ul class="nav nav-tabs" id="boardmenu" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" id="humor-tab" data-toggle="tab" href="#humor" role="tab" aria-controls="humor" aria-selected="true"
            href="<?php echo e("board"); ?>?board_type=none&board_category=humor"
            >유머</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="photo-tab" data-toggle="tab" href="#photo" role="tab" aria-controls="photo" aria-selected="false"
            >포토</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="pick-tab" data-toggle="tab" href="#pick" role="tab" aria-controls="pick" aria-selected="false">분석픽공유</a>
		</li>
		<li class="nav-item">
			<a class="nav-link none" id="free-tab" data-toggle="tab" href="#free" role="tab" aria-controls="free" aria-selected="false">자유</a>
		</li>
    </ul>
	<div class="tab-content" id="tabBoard">
		<div class="tab-pane active" id="humor" role="tabpanel" aria-labelledby="humor-tab">
			<div class="listBox" id="list_humor">
				<div class="left">
					<ul class="list">
                        <?php for($i = 0; $i < 6 ;$i++): ?>
                        <?php if(!empty($humor[$i])): ?>
                                <li ><img src="<?php echo e(checkImage($humor[$i]["content"])); ?>" width="30" height="26">
                                    <a href="/board?board_type=none&board_category=humor&bid=<?php echo e($humor[$i]["id"]); ?>&page=1" target="mainFrame" title="<?php echo e($humor[$i]["title"]); ?>"><?php echo e($humor[$i]["title"]); ?></a>
                                    <?php if(sizeof($humor[$i]["comments"]) > 0): ?>
                                        <span class="comment">[<?php echo e(sizeof($humor[$i]["comments"])); ?>]</span>
                                    <?php endif; ?>
                                </li>
                        <?php endif; ?>
                        <?php endfor; ?>
					</ul>
				</div>
				<div class="right">
					<ul class="list">
                        <?php for($i = 6; $i < 12 ;$i++): ?>
                            <?php if(!empty($humor[$i])): ?>
                                <li><img src="<?php echo e(checkImage($humor[$i]["content"])); ?>" width="30" height="26">
                                    <a href="/board?board_type=none&board_category=humor&bid=<?php echo e($humor[$i]["id"]); ?>&page=1" target="mainFrame" title="<?php echo e($humor[$i]["title"]); ?>"><?php echo e($humor[$i]["title"]); ?></a>
                                    <?php if(sizeof($humor[$i]["comments"]) > 0): ?>
                                        <span class="comment">[<?php echo e(sizeof($humor[$i]["comments"])); ?>]</span>
                                    <?php endif; ?>
                                </li>
                            <?php endif; ?>
                        <?php endfor; ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="tab-pane fade" id="photo" role="tabpanel" aria-labelledby="photo-tab">
			<div class="listBox" id="list_photo">
				<ul class="list">
                    <?php $__currentLoopData = $photo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="photo">
                            <a href="/board?board_type=none&board_category=humor&bid=<?php echo e($p["id"]); ?>&page=1" target="mainFrame" title="">
                                <?php echo extractImage($p["content"]); ?></a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</ul>
			</div>
		</div>
		<div class="tab-pane fade" id="pick" role="tabpanel" aria-labelledby="pick-tab">
			<div class="listBox" id="list_pick">
				<div class="left">
					<ul class="list">
                        <?php for($i = 0; $i < 6 ;$i++): ?>
                            <?php if(!empty($pick[$i])): ?>
                                <li ><img src="<?php echo e(checkImage($pick[$i]["content"])); ?>" width="30" height="26">
                                    <a href="/board?board_type=none&board_category=humor&bid=<?php echo e($pick[$i]["id"]); ?>&page=1" target="mainFrame" title="<?php echo e($pick[$i]["title"]); ?>"><?php echo e($pick[$i]["title"]); ?></a>
                                    <?php if(sizeof($pick[$i]["comments"]) > 0): ?>
                                        <span class="comment">[<?php echo e(sizeof($pick[$i]["comments"])); ?>]</span>
                                    <?php endif; ?>
                                </li>
                            <?php endif; ?>
                        <?php endfor; ?>
					</ul>
				</div>
				<div class="bar"></div>
				<div class="right">
					<ul class="list">
                        <?php for($i = 6; $i < 12 ;$i++): ?>
                            <?php if(!empty($pick[$i])): ?>
                                <li ><img src="<?php echo e(checkImage($pick[$i]["content"])); ?>" width="30" height="26">
                                    <a href="/board?board_type=none&board_category=humor&bid=<?php echo e($pick[$i]["id"]); ?>&page=1" target="mainFrame" title="<?php echo e($pick[$i]["title"]); ?>"><?php echo e($pick[$i]["title"]); ?></a>
                                    <?php if(sizeof($pick[$i]["comments"]) > 0): ?>
                                        <span class="comment">[<?php echo e(sizeof($pick[$i]["comments"])); ?>]</span>
                                    <?php endif; ?>
                                </li>
                            <?php endif; ?>
                        <?php endfor; ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="tab-pane fade" id="free" role="tabpanel" aria-labelledby="free-tab">
			<div class="listBox" id="list_free">
				<div class="left">
					<ul class="list">
                        <?php for($i = 0; $i < 6 ;$i++): ?>
                            <?php if(!empty($free[$i])): ?>
                                <li ><img src="<?php echo e(checkImage($free[$i]["content"])); ?>" width="30" height="26">
                                    <a href="/board?board_type=none&board_category=humor&bid=<?php echo e($free[$i]["id"]); ?>&page=1" target="mainFrame" title="<?php echo e($free[$i]["title"]); ?>"><?php echo e($free[$i]["title"]); ?></a>
                                    <?php if(sizeof($free[$i]["comments"]) > 0): ?>
                                        <span class="comment">[<?php echo e(sizeof($free[$i]["comments"])); ?>]</span>
                                    <?php endif; ?>
                                </li>
                            <?php endif; ?>
                        <?php endfor; ?>
					</ul>
				</div>
				<div class="bar"></div>
				<div class="right">
					<ul class="list">
                        <?php for($i = 6; $i < 12 ;$i++): ?>
                            <?php if(!empty($free[$i])): ?>
                                <li ><img src="<?php echo e(checkImage($free[$i]["content"])); ?>" width="30" height="26">
                                    <a href="/board?board_type=none&board_category=humor&bid=<?php echo e($free[$i]["id"]); ?>&page=1" target="mainFrame" title="<?php echo e($free[$i]["title"]); ?>"><?php echo e($free[$i]["title"]); ?></a>
                                    <?php if(sizeof($free[$i]["comments"]) > 0): ?>
                                        <span class="comment">[<?php echo e(sizeof($free[$i]["comments"])); ?>]</span>
                                    <?php endif; ?>
                                </li>
                            <?php endif; ?>
                        <?php endfor; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<ul class="bannerBox" id="banner_main_area">
<img src="/assets/images/ads.png" width="200" height="205">
</ul>
<?php /**PATH D:\xampp1\htdocs\powerball\resources\views/layouts/boardBox.blade.php ENDPATH**/ ?>