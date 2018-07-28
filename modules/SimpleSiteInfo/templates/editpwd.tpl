{$startform}
<p class="information">{$moddescription}</p>
<div class="pageoverflow">
    <p class="pagetext">{$cdkeytext}:</p>
    <p class="pageinput">{$inputcdkey1}-{$inputcdkey2}</p>
</div>
<div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">
    {if isset($idfield)}{$idfield}{/if}
    <input class="cms_submit" name="m1_submit" id="m1_submit" value="{$create_new_pwd}" type="submit" onclick="return confirm('{$confirm_change_pwd}')" />
</p>
</div>
{if !empty( $debug_mode)}
    <hr />
    <div class="information">
        <p><b>Debug information</b></p>
        <p>When an update data request is received from the SimpleSiteMgr module, it will be mentioned in this website's Admin Log.</p>
        <br />
        {if !empty ( $open_file ) }
            <p>The data file is present: <a href="{$open_file}" class="external" target="_blank">{$open_file}</a></p>
            <p>Don't worry if you can't read it... Neither can the bad ass trying to hack your site :)</p>
        {else}
            <p>Data file is NOT available!</p>
        {/if}
    </div>
{/if}
{$endform}

<script>
$(document).ready(function() {
    $('input').live('keyup', function(e) {
  $(this).val($(this).val().replace(/[^0-9]/g, ''));
});
});
    </script>