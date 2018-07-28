<div class="information">{$mod->Lang('info_graphicssettings')}</div>

<div class="c_full cf">
  {$input_submit}
</div>

<fieldset>
  <div class="c_full cf">
    <label class="grid_4">{$mod->Lang('image_extensions')}:</label>
    <div class="grid_7">
      <input type="text" name="{$actionid}imageextensions" class="grid_12" maxlength="255" value="{$imageextensions}"/>
      <p>{$mod->Lang('info_imageextensions')}</p>
    </div>
  </div>

  <div class="c_full cf">
    <label class="grid_4">{$mod->Lang('prompt_allow_resizing')}</label>
    <p class="grid_7">{$input_allow_resizing}</p>
  </div>
  <div class="c_full cf">
    <label class="grid_4">{$mod->Lang('prompt_delete_orig_image')}</label>
    <p class="grid_7">{$input_delete_orig_image}</p>
  </div>
  <div class="c_full cf">
    <label class="grid_4">{$mod->Lang('resize_image_to')}:</label>
    <label class="grid_7">{$input_resizeimage}&nbsp;px</label>
  </div>
</fieldset>

<fieldset>
  <legend><strong>{$mod->Lang('watermarking')}:</strong></legend>
  <div class="information">{$mod->Lang('info_watermarks')}</div>
  <div class="c_full cf">
    <label class="grid_4">{$mod->Lang('prompt_allow_watermarking')}</label>
    <p class="grid_7">{$input_allow_watermarking}</p>
  </div>
  <div class="c_full cf">
    <label class="grid_4">{$mod->Lang('watermark_alignment')}</label>
    <p class="grid_7">{$input_alignment}</p>
  </div>

  <div class="c_full cf">
    <fieldset class="grid_8">
      <legend>{$mod->Lang('text_watermarks')}</legend>
          <div class="c_full cf">
            <p class="grid_3">{$mod->Lang('watermark_text')}:</p>
            <p class="grid_8">{$input_text}</p>
          </div>
          <div class="c_full cf">
            <p class="grid_3">{$mod->Lang('text_color')}:</p>
            <p class="grid_8">{$input_textcolor}</p>
          </div>
          <div class="c_full cf">
            <p class="grid_3">{$mod->Lang('background_color')}:</p>
            <p class="grid_8">{$input_bgcolor}</p>
          </div>
          <div class="c_full cf">
            <p class="grid_3">{$mod->Lang('use_transparency')}:</p>
            <p class="grid_8">{$input_transparent}:</p>
          </div>
          <div class="c_full cf">
            <p class="grid_3">{$mod->Lang('font')}:</p>
            <p class="grid_8">{$input_font}</p>
          </div>
          <div class="c_full cf">
            <p class="grid_3">{$mod->Lang('font_size')}:</p>
            <p class="grid_8">{$input_textsize}</p>
          </div>
          <div class="c_full cf">
            <p class="grid_3">{$mod->Lang('text_angle')}:</p>
            <p class="grid_8">{$input_textangle}</p>
          </div>
          <div class="c_full cf">
            <p class="grid_3">{$mod->Lang('translucency')}:</p>
            <p class="grid_8">{$input_translucency}</p>
          </div>
    </fieldset>

    <fieldset class="grid_4">
          <legend>{$mod->Lang('graphic_watermarks')}</legend>
          <div class="c_full cf">
            <p class="grid_3">{$mod->Lang('image')}:</p>
            <p class="grid_8">{$input_image}</p>
          </div>
    </fieldset>
</fieldset>

<fieldset>
<legend>{$mod->Lang('thumbnailing')}:</legend>
  <div class="c_full cf">
    <label class="grid_4">{$mod->Lang('prompt_allow_thumbnailing')}</label>
    <p class="grid_7">{$input_allow_thumbnailing}</p>
  </div>
  <div class="c_full cf">
    <label class="grid_4">{$mod->Lang('thumbnail_size')}:</label>
    <p class="grid_7">{$input_thumbnailsize}&nbsp;px</p>
  </div>
</fieldset>
