<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div id="simpleJoinBox">
            <div class="card">
                <div class="card-body">
                    <div class="content">
                        <form method="POST" action="<?php echo e(route('register')); ?>" id="reg">
                            <?php echo csrf_field(); ?>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input id="loginId" type="text" class="form-control <?php $__errorArgs = ['loginId'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="loginId" value="<?php echo e(old('loginId')); ?>" required autocomplete="name" autofocus
                                    placeholder="<?php echo e(__('아이디를 입력하세요...')); ?>">

                                    <?php $__errorArgs = ['loginId'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required autocomplete="new-password"
                                    placeholder="<?php echo e(__('비밀번호')); ?>">

                                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password"
                                    placeholder="<?php echo e(__('비밀번호 확인')); ?>">
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input id="nickname" type="text" class="form-control <?php $__errorArgs = ['nickname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="nickname" value="<?php echo e(old('nickname')); ?>" required autocomplete="nickname" autofocus
                                    placeholder="닉네임을 입력하세요...">

                                    <?php $__errorArgs = ['nickName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input id="name" type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name" value="<?php echo e(old('name')); ?>" required autocomplete="name" autofocus
                                    placeholder="이름을 입력하세요...">
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <input id="phoneNumber" type="text" class="form-control <?php $__errorArgs = ['phoneNumber'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="phoneNumber" require value="<?php echo e(old('phoneNumber')); ?>" required autocomplete="phoneNumber" autofocus
                                               placeholder="휴대폰번호를 입력하세요">
                                        <div class="input-group-append">
                                            <button class="btn btn-jin-greenoutline" type="button" onclick="sendPhoneNumber()">휴대폰번호 발송</button>
                                        </div>
                                    </div>

                                    <?php $__errorArgs = ['phoneNumber'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <input id="smsAuthNum" type="text" class="form-control <?php $__errorArgs = ['smsAuthNum'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="smsAuthNum" value="<?php echo e(old('smsAuthNum')); ?>"  autocomplete="phoneNumber" autofocus
                                               placeholder="인증번호를 입력하세요...">
                                        <div class="input-group-append">
                                            <button class="btn btn-jin-greenoutline" type="button" onclick="checkAuth()">인증번호 확인</button>
                                        </div>
                                    </div>
                                    <?php $__errorArgs = ['smsAuthNum'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" placeholder="<?php echo e(__('이메일을 입력하세요...')); ?>">

                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-jin-greenoutline btn-block">
                                        <?php echo e(__('회원가입하기')); ?>

                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="footer">
                        <p>이미 몬스터파워볼 회원이세요? <a href="<?php echo e(route('default')); ?>" class="text-blue">로그인하기</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <script>
        var sms_auth = false
        $(document).ready(function(){
            $("#reg").submit(function(event) {
                /* stop form from submitting normally */
                event.preventDefault();
                if(!isCellPhone($("#phoneNumber").val())){
                    alert("전화번호 형식이 옳바르지 않습니다.");
                }
                if(!sms_auth)
                {
                    alert("인증번호확인이 되어 있지 않습니다.");
                    return false;
                }
                $("#reg")[0].submit();
            });
        });
        function isCellPhone(p) {
            p = p.split('-').join('');
            var regPhone = /^((01[1|6|7|8|9])[1-9]+[0-9]{6,7})|(010[1-9][0-9]{7})$/;
            return regPhone.test(p);
        }

        function sendPhoneNumber(){
            if(!isCellPhone($("#phoneNumber").val())){
                alert("전화번호 형식이 옳바르지 않습니다.");
                return;
            }
            $.ajax({
                type: "POST",
                url: "/api/sendSmsPhoneNum",
                data:{"phone":$("#phoneNumber").val()},
                dataType:"json"
            }).done(function(data) {
                if(data.status == 1){
                    $("#phoneNumber").attr("readOnly", true)
                }
                alert(data.msg)
            })
        }

        function checkAuth(){
            if($("#smsAuthNum").val().length < 4){
                alert("네자리 숫자를 입력하세요");
                return;
            }
            $.ajax({
                type: "POST",
                url: "/api/checkAuth",
                data:{"auth":$("#smsAuthNum").val(),"phone":$("#phoneNumber").val()},
                dataType:"json"
            }).done(function(data) {
                if(data.status == 1)
                    sms_auth = true;
                alert(data.msg)
            })
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/auth/register.blade.php ENDPATH**/ ?>