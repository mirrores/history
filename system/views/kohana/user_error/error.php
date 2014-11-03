<?php
// Unique error identifier
$error_id = uniqid('error');
?>
<div id="kohana_error" style="font-family: verdana">
    <span class="type">Sorry:</span> <span class="message"><?php echo html::chars($message) ?></span>
</div>

