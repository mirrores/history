<script type="text/javascript">
    $(document).ready(function() {
        readyScript.footer = getToTop;
<?php if ($_UID): ?>readyScript.msg = function(){setTimeout(function() {check_pm_notice();}, 3000);};<?php endif;?>
<?php if ($_SESS->get('prompt')): ?>showPrompt('<?= $_SESS->get('prompt') ?>', 2000); <?= $_SESS->delete('prompt') ?><?php endif; ?>
<?php if ($_SESS->get('checkJoinEvent')): ?>setTimeout(function() { checkjoinevent(); }, 4000);<?= $_SESS->delete('checkJoinEvent') ?><?php endif; ?>
runReadyScript();
    });
</script>