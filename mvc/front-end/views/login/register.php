
        <div class="container">
                <form action="" method="post">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?php
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($this->error)): ?>
                        <div class="alert alert-danger">
                            <?php
                            echo $this->error;
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success">
                            <?php
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                            ?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm password</label>
                        <input type="password" id="password_confirm" name="password_confirm" class="form-control">
                    </div>
                    <input type="submit" name="submit" value="Đăng ký" class="btn btn-primary">
                    <p>
                        Đã có tài khoản, <a href="index.php?controller=user&action=login" style="color: #0b0b0b">Đăng nhập</a>
                    </p>
                </form>
        </div>