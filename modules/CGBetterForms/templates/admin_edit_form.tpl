{if $form->id < 1}
<h3>{$mod->Lang('add_new_form')}</h3>
{else}
<h3>{$mod->Lang('editing_form')}</h3>
{/if}

<script>
validationHandler = function(sel) {
    var element, e_savebtn, e_subaction, e_guidlist;
    var var_prefix = '{$actionid}';

    // construct
    element = sel;
    e_form = element.closest('form');
    e_savebtn = $('#save_validation_order');
    e_subaction = $('#subaction');
    e_guidlist = $('#guid_list');

    e_savebtn.click(function(ev){
           ev.preventDefault();
           cms_confirm('save these positions').done(function(){
	      var list = [];
	      $('tr',element).each(function(){
	         var t = $(this).data('guid');
		 if( !t || t.length == 0 ) return;
		 list.push(t);
              });
	      // now save this data somewhere, and submit the form.
	      e_subaction.val('order_validations');
	      e_guidlist.val(list.join(','));
	      e_form.submit();
           })
    });

    $('tbody',element).sortable({
       cursor: 'move',
       helper: function(ev, ui) {
          ui.children().each(function() {
              $(this).width($(this).width());
          });
    	  return ui;
       },
       stop: function(event,ui) {
           e_savebtn.show();
       },
    });
};

dispositionHandler = function(sel) {
    var element, e_savebtn, e_subaction, e_guidlist;
    var var_prefix = '{$actionid}';

    // construct
    element = sel;
    e_form = element.closest('form');
    e_savebtn = $('#save_disp_order');
    e_subaction = $('#subaction');
    e_guidlist = $('#guid_list');

    e_savebtn.click(function(ev){
           ev.preventDefault();
           cms_confirm('save these positions').done(function(){
	      var list = [];
	      $('tr',element).each(function(){
	         var t = $(this).data('guid');
		 if( !t || t.length == 0 ) return;
		 list.push(t);
              });
	      // now save this data somewhere, and submit the form.
	      e_subaction.val('order_dispositions');
	      e_guidlist.val(list.join(','));
	      e_form.submit();
           })
    });

    $('tbody',element).sortable({
       cursor: 'move',
       helper: function(ev, ui) {
          ui.children().each(function() {
              $(this).width($(this).width());
          });
    	  return ui;
       },
       stop: function(event,ui) {
           e_savebtn.show();
       },
    });
};

$( function() {
   // ready..
   var disp_handler = new dispositionHandler($('#disposition_list'));
   var disp_handler = new validationHandler($('#validation_list'));
})
</script>

<style type="text/css">
button.btnlink {
   background:none!important;
   color:inherit;
   border:none;
   padding:0!important;
   font: inherit;
   /*border is optional*/
   cursor: pointer;
}
tr.badfield td {
   color: orange !important;
}
#disposition_list {
   cursor: move;
}
#validation_list {
   cursor: move;
}
</style>

{form_start form_guid=$form_guid}<input id="subaction" name="{$actionid}subaction" type="hidden"/><input id="guid_list" type="hidden" name="{$actionid}guids"/>
{$dispositions=$form->dispositions}
{$validations=$form->validations}

<div class="pageoverflow">
   {if count($fields)}
     <input type="submit" name="{$actionid}submit" value="{$mod->Lang('save')}"/>
     <input type="submit" name="{$actionid}apply" value="{$mod->Lang('apply')}"/>
   {/if}
   <input type="submit" name="{$actionid}scan" value="{$mod->Lang('scan')}"/>
   <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}" formnovalidate/>
</div>

{cge_start_tabs}
{cge_tabheader name='form' label=$mod->Lang('form')}
{if count($messages)}
  {cge_tabheader name='messages' label=$mod->Lang('messages')}
{/if}
{if count($fields)}
  {cge_tabheader name='fields' label=$mod->Lang('fields')}
  {cge_tabheader name='prerender_logic' label=$mod->Lang('prerender_logic')}
  {cge_tabheader name='validation' label=$mod->Lang('validation')}
  {cge_tabheader name='handlers' label=$mod->Lang('handlers')}
  {cge_tabheader name='final' label=$mod->Lang('final')}
{/if}

{cge_tabcontent_start name='form'}
  <div class="c_full cf">
    <label class="grid_2 required">*{$mod->Lang('form_name')}:</label>
    <input class="grid_9 required" name="{$actionid}name" value="{$form->name}" placeholder="{$mod->Lang('ph_form_name')}" required/>
  </div>
  <div class="c_full cf">
    <label class="grid_2 required">*{$mod->Lang('form_template')}:</label>
    <select name="{$actionid}template_id" class="grid_9" required>
      {html_options options=$all_templates selected=$form->template_id}
    </select>
  </div>
  <div class="c_full cf">
    <label class="grid_2 required">{$mod->Lang('description')}:</label>
    <textarea class="grid_9" name="{$actionid}description" placeholder="{$mod->Lang('ph_form_desc')}">{$form->description}</textarea>
  </div>

  <hr/>
  <div class="c_full cf">
     <label class="grid_2">{$mod->Lang('form_from_email')}</label>
     <div class="grid_9">
       <input class="grid_12" type="email" name="{$actionid}email_from_addr" value="{$form->email_from_addr}" placeholder="{$mod->Lang('emailaddr_sysdflt')}"/>
       <p class="grid_12">{$mod->Lang('info_form_from_email')}</p>
     </div>
  </div>

  <div class="c_full cf">
     <label class="grid_2">{$mod->Lang('form_from_name')}</label>
     <div class="grid_9">
       <input class="grid_12" type="text" name="{$actionid}email_from_name" value="{$form->email_from_name}" placeholder="{$mod->Lang('none')}"/>
       <p class="grid_12">{$mod->Lang('info_form_from_name')}</p>
     </div>
  </div>

  <hr/>
  <div class="c_full cf">
     <label class="grid_2">{$mod->Lang('form_inline')}</label>
     <div class="grid_9">
       {cge_yesno_options prefix=$actionid name=display_inline selected=$form->display_inline}
       <p class="grid_12">{$mod->Lang('info_form_inline')}</p>
     </div>
  </div>

  <div class="c_full cf">
     <label class="grid_2">{$mod->Lang('use_async_upload')}</label>
     <div class="grid_9">
       {cge_yesno_options prefix=$actionid name=use_async_upload selected=$form->use_async_upload}
       <p class="grid_12">{$mod->Lang('info_use_async_upload')}</p>
     </div>
  </div>

{if count($messages)}
  {cge_tabcontent_start name=messages}
  <div class="information">{$mod->Lang('info_form_messages')}</div>
  {if empty($messages)}
      <div class="information">{$mod->Lang('no_messages')}</div>
  {else}
       <ul>
         {foreach $messages as $msg}
	   <li>{$msg}</li>
	 {/foreach}
       </ul>
  {/if}
{/if}

{if count($fields)}
  {cge_tabcontent_start name=fields}
      <div class="information">{$mod->Lang('info_fields_tab')}</div>
      <table class="pagetable">
        <thead>
	  <r>
	    <th>{$mod->Lang('name')}</th>
	    <th>{$mod->Lang('label')}</th>
	    <th>{$mod->Lang('node')}</th>
	    <th>{$mod->Lang('type')}</th>
	    <th>{$mod->Lang('attribs')}</th>
	  </tr>
	</thead>
	<tbody>
	{foreach $fields as $field}
	  <tr class="{cycle values='row1,row2'}">
	    <td>{$field->name}</td>
	    <td>{$field->label}</td>
	    <td>{$field->node}</td>
	    <td>{$field->type}</td>
	    <td>
	      {$attribs=[]}
	      {if $field->novalidate}{$attribs[]=$mod->Lang('attr_novalidate')}{/if}
	      {if $field->primitive != 'string'}{$attribs[]=$field->primitive}{/if}
	      {if $field->multiple}{$attribs[]=$mod->Lang('attr_multiple')}{/if}
	      {if $field->min}{$attribs[]=$mod->Lang('attr_min')}{/if}
	      {if $field->max}{$attribs[]=$mod->Lang('attr_max')}{/if}
	      {if $field->pattern}{$attribs[]=$mod->Lang('attr_pattern')}{/if}
	      {implode(', ',$attribs)}
	    </td>
	  </tr>
	{/foreach}
	</tbody>
      </table>

{cge_tabcontent_start name=prerender_logic}
    <div class="information">{$mod->Lang('info_prerender_tab')}</div>

    <div class="pageoverflow">
        <p class="pagetext">{$mod->Lang('prompt_prerender_logic')}</p>
        <p class="pageinput">
            <textarea name="{$actionid}prerender_logic" rows="10">{$form->prerender_logic}</textarea>
        </p>
    </div>

{cge_tabcontent_start name=validation}
    <div class="information">{$mod->Lang('info_form_validations')}</div>
    <div class="c_full cf">
      <p class="grid_2">{$mod->Lang('add_validation')}</p>
      <select class="grid_7" name="{$actionid}validation">
        {html_options options=$all_validations}
      </select>
      <button name="{$actionid}add_validation">{$mod->Lang('add')}</button>
      <button name="{$actionid}auto_validation">{$mod->Lang('auto_add_validations')}</button>
    </div>
    {if !empty($validations)}
      <div class="c_full cf">
         <button id="save_validation_order" style="display: none;">{$mod->Lang('save')}</button>
      </div>
      <table id="validation_list" class="pagetable">
        <thead>
	  <tr>
	    <th>{$mod->Lang('validation')}</th>
	    <th class="pageicon"></th>
	    <th class="pageicon"></th>
	  </tr>
	</thead>
	<tbody>
        {foreach $validations as $handler}
          <tr class="{cycle values='row1,row2'}" data-guid="{$handler->get_guid()}">
 	    <td>{$mod->get_validation_displaystring($handler)}</td>
	    <td>
	      {if $mod->validation_has_editor($handler)}
	        <button class="btnlink" name="{$actionid}edit_validation" value="{$handler->get_guid()}" title="{$mod->Lang('edit')}">{admin_icon icon='edit.gif'}</button>
	      {/if}
	    </td>
	    <td>
	       <button class="btnlink" name="{$actionid}del_validation" value="{$handler->get_guid()}" title="{$mod->Lang('delete')}">{admin_icon icon='delete.gif'}</button>
	    </td>
	  </tr>
        {/foreach}
	</tbody>
      </table>
    {/if}

{cge_tabcontent_start name=handlers}
  <div class="information">{$mod->Lang('info_form_handlers')}</div>
  <div class="c_full cf">
    <p class="grid_2">{$mod->Lang('add_disposition')}</p>
    <select class="grid_7" name="{$actionid}disposition">
      {html_options options=$all_dispositions}
    </select>
    <button name="{$actionid}add_disposition">{$mod->Lang('add')}</button>
  </div>
  {if !empty($dispositions)}
    <div class="c_full cf">
       <button id="save_disp_order" style="display: none;">{$mod->Lang('save')}</button>
    </div>
    <table id="disposition_list" class="pagetable">
      <thead>
        <tr>
	  <th>{$mod->Lang('handler')}</th>
	  <th class="pageicon"></th>
	  <th class="pageicon"></th>
	</tr>
      </thead>
      <tbody>
      {foreach $dispositions as $handler}
        <tr class="{cycle values='row1,row2'}" data-guid="{$handler->get_guid()}">
          <td>{$mod->get_disposition_displaystring($handler)}</td>
	  <td><button class="btnlink" name="{$actionid}edit_disposition" value="{$handler->get_guid()}" title="{$mod->Lang('edit')}">{admin_icon icon='edit.gif'}</button></td>
	  <td>
              <button class="btnlink" name="{$actionid}del_disposition" value="{$handler->get_guid()}" title="{$mod->Lang('delete')}">{admin_icon icon='delete.gif'}</button>
	  </td>
        </tr>
      {/foreach}
      </tbody>
    </table>
  {/if}

{cge_tabcontent_start name='final'}
  <div class="information">{$mod->Lang('info_final_disposition')}</div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_finalaction')}:</p>
    <p class="pageinput">
      <label><input type="radio" name="{$actionid}finalaction" value="message" {if $form->finalaction!="redirect"}checked{/if}/> {$mod->Lang('prompt_dofinalmsg')}</label><br/>
      <label><input type="radio" name="{$actionid}finalaction" value="redirect" {if $form->finalaction=="redirect"}checked{/if}/> {$mod->Lang('prompt_dofinalredirect')}</label>
    </p>
  </div>

  <div class="pageoverflow" id="sel_finalpage">
    <p class="pagetext">{$mod->Lang('prompt_finalpage')}</p>
    <p class="pageinput">
      {page_selector name="{$actionid}finalpage" value=$form->finalpage}
    </p>
  </div>

  <div class="pageoverflow" id="sel_finalmessage">
    <p class="pagetext">{$mod->Lang('prompt_finalmessage')}</p>
    <p class="pageinput">
      <textarea name="{$actionid}finalmsg" rows="20">{$form->finalmsg}</textarea>
    </p>
  </div>

  {$form_help}
{/if}{* count($fields) *}
{cge_end_tabs}
{form_end}