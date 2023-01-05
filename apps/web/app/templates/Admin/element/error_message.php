<div id="error_message_waku">
<?php if (!empty($error_messages) || $this->Common->session_check('Flash.flash.0.message')): ?>
    <div class="error">
            <?= $error_messages; ?>
            <div><?= $this->Flash->render(); ?></div>
    </div>
<?php endif; ?>
</div>