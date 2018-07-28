{cgcss_add}
h4 {
  margin-bottom: 0.2em;
}
{/cgcss_add}
{if isset($simple) && !$simple && isset($dflt_tpl_counter) && $dflt_tpl_counter == 0}
<script type="text/javascript">
$(document).ready(function(){
  $('h4.cge_dflt_template_hdr').click(function(){
    $('.cge_dflt_template').hide();
    $(this).next('.cge_dflt_template').show();
    $('html,body').animate({ scrollTop: $(this).offset().top });
  });
  $('.cge_dflt_template').hide();
  $('.cge_dflt_template').first().show();
});
</script>
{/if}

{if isset($defaulttemplateform_title)}
  {if isset($simple) && $simple}
    <h4>{$defaulttemplateform_title}</h4>
  {else}
    <h4 id="{$prefname}" class="cge_dflt_template_hdr"><a href="javascript:return false;"><span class="cge_toggle">+</span>&nbsp;{$defaulttemplateform_title}</a></h4>
  {/if}
{/if}

<div class="cge_dflt_template">
{$startform}
{if isset($info_title) && $info_title}
  <div class="information">{$info_title}</div>
{/if}
<div class="pageoverflow" id="{$prefname}_tpl">
  <p class="pagetext">{$prompt_template}:</p>
  <p class="pageinput">
    {cge_textarea syntax=1 prefix=$actionid name=input_template value=$template_src}
    {$submit}{$reset}
  </p>
</div>
{$endform}
</div>
