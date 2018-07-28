<style>
    .button_sync {
	background-color:#3bb3e0;
	position:relative;
	font-family: 'Open Sans', sans-serif;
	font-size:12px;
	text-decoration:none;
	color:#fff;
	border: solid 1px #186f8f;
	background-image: linear-gradient(bottom, rgb(44,160,202) 0%, rgb(62,184,229) 100%);
	background-image: -o-linear-gradient(bottom, rgb(44,160,202) 0%, rgb(62,184,229) 100%);
	background-image: -moz-linear-gradient(bottom, rgb(44,160,202) 0%, rgb(62,184,229) 100%);
	background-image: -webkit-linear-gradient(bottom, rgb(44,160,202) 0%, rgb(62,184,229) 100%);
	background-image: -ms-linear-gradient(bottom, rgb(44,160,202) 0%, rgb(62,184,229) 100%);
	background-image: -webkit-gradient(
	linear,
	left bottom,
	left top,
	color-stop(0, rgb(44,160,202)),
	color-stop(1, rgb(62,184,229))
	);
	-webkit-box-shadow: inset 0px 1px 0px #7fd2f1, 0px 1px 0px #fff;
	-moz-box-shadow: inset 0px 1px 0px #7fd2f1, 0px 1px 0px #fff;
	box-shadow: inset 0px 1px 0px #7fd2f1, 0px 1px 0px #fff;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	-o-border-radius: 5px;
	border-radius: 5px;
}
.button_reset {
	background-color:#3bb3e0;
	position:relative;
	font-family: 'Open Sans', sans-serif;
	font-size:12px;
	text-decoration:none;
	color:#fff;
	border: solid 1px #186f8f;
	background-image: linear-gradient(bottom, rgb(44,160,202) 0%, rgb(62,184,229) 100%);
	background-image: -o-linear-gradient(bottom, rgb(44,160,202) 0%, rgb(62,184,229) 100%);
	background-image: -moz-linear-gradient(bottom, rgb(44,160,202) 0%, rgb(62,184,229) 100%);
	background-image: -webkit-linear-gradient(bottom, rgb(44,160,202) 0%, rgb(62,184,229) 100%);
	background-image: -ms-linear-gradient(bottom, rgb(44,160,202) 0%, rgb(62,184,229) 100%);
	background-image: -webkit-gradient(
	linear,
	left bottom,
	left top,
	color-stop(0, rgb(44,160,202)),
	color-stop(1, rgb(0,0,0))
	);
	-webkit-box-shadow: inset 0px 1px 0px #7fd2f1, 0px 1px 0px #fff;
	-moz-box-shadow: inset 0px 1px 0px #7fd2f1, 0px 1px 0px #fff;
	box-shadow: inset 0px 1px 0px #7fd2f1, 0px 1px 0px #fff;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	-o-border-radius: 5px;
	border-radius: 5px;
}
</style>
<div style="clear:both" class="pageoptions"><p class="pageoptions">{$addlink}</p></div>
    {if $itemcount > 0}
    <table cellspacing="0"  class="pagetable">
        <thead>
            <tr>
                <th>{$mod->Lang('idtext')}</th>
                <th>{$mod->Lang('name')}</th>
                <th>{$mod->Lang('alias')}</th>
                <th>{$mod->Lang('locale')}</th>
                <th class="pageicon" style="width:50px;">{$mod->Lang('default')}</th>
                <th class="pageicon" style="width:50px;">{$mod->Lang('active')}</th>
                <th class="pageicon" style="width:50px;"></th>
                <th class="pageicon" style="width:50px;"></th>
                <th class="pageicon" style="width:50px;"></th>
                <th class="pageicon" style="width:50px;"></th>
                <th class="pageicon" style="width:30px;"></th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$items item=entry}
                {cycle values="row1,row2" assign='rowclass'}
                {capture assign="pay_type"}pay_types{$entry->payment_type}{/capture}
                <tr class="{$rowclass}" onmouseover="this.className = '{$rowclass}hover';" onmouseout="this.className = '{$rowclass}';">
                    <td>{$entry->id}</td>
                    <td>{$entry->title}</td>
                    <td>{$entry->alias}</td>
                    <td>{$entry->locale}</td>
                    {assign var="df" value="{$entry->locale}"}
                    <td style="text-align:center;"><input type="radio" name="default_language" data-locale="{$entry->locale}" {if (get_site_preference('default_lang_mle') != $entry->locale)}class="SetDefaultMle"{/if} {if get_site_preference("default_lang_mle") == $df}checked="checked"{/if}/></td>
                    <td style="text-align:center;">{if (get_site_preference('default_lang_mle') == $entry->locale)}
                        {admin_icon icon='true.gif' class='page_default' title=$mod->Lang('prompt_page_default')}
                        {else if ($entry->active == 1)}
                            <a href="" data-id="{$entry->id}" data-alias="{$entry->alias}" data-value="0" class="set_active" accesskey="d">
                                {admin_icon icon='true.gif' class='page_setdefault' title=$mod->Lang('prompt_page_disablelanguage')}
                            </a>
                            {else}
                                <a href="" data-id="{$entry->id}" data-alias="{$entry->alias}" data-value="1" class="set_active" accesskey="d">
                                    {admin_icon icon='false.gif' class='page_setdefault' title=$mod->Lang('prompt_page_enablelanguage')}
                                </a>
                                {/if}
                                </td>
                                <td style="text-align:center;">
                                    
                                {if isset($entry->moveuplink)}{$entry->moveuplink}{/if}
                            {if isset($entry->movedownlink)}{$entry->movedownlink}{/if}
                           
                        </td>
                        <td style="text-align:center;">{if $entry->alias != 'en'}<button class="syncdata button_sync" data-alias="{$entry->alias}">Sync</button>{/if}</td>
                        <td style="text-align:center;">{if $entry->alias != 'en'}<button class="resetdata button_reset" data-alias="{$entry->alias}">Reset</button>{/if}</td>
                        <td style="text-align:center;">{if $entry->alias != 'en'}{$entry->editlink}{/if}</td>
                        <td style="text-align:center;">{if $entry->alias != 'en'}{$entry->deletelink}{/if}</td>
                    </tr>
                    {/foreach}
                    </tbody>
                </table>
                <div class="pageoptions"><p class="pageoptions">{$addlink}</p></div>
                    {/if}

{literal}
    <script type="text/javascript">
    {/literal}
        var areyousure = "{$mod->Lang('areyousure_setdefaultmle')}";
    {literal}
        $(document).ready(function () {
            $('.set_active').live('click', function () {
                var avalue = $(this).attr('data-value');
                var aid = $(this).attr('data-id');
                var alias = $(this).attr('data-alias');
                $.ajax({
                    type: 'POST',
                    url: '{/literal}{cms_action_url action='admin_ajax_set_active'}{literal}',
                    dataType: 'json',
                    data: ({
                        'avalue': avalue,
                        'aid': aid,
                        'alias': alias,
                        '{/literal}{$cms_secure_param_name}{literal}': '{/literal}{$smarty.get.$cms_secure_param_name}{literal}',
                        'module': '{/literal}{$mod->GetName()}{literal}',
                        'showtemplate': 'false',
                        'cg_activetab': 'mle_config',
                        'aAction': 'SetActive'
                    }),
                    complete: function (e) {
                        if (e.statusText == "OK") {
                            location.reload();
                        } else {
                            console.log(e);
                        }
                    }
                });
            });
            
            $('.syncdata').live('click', function () {
                var alias = $(this).attr('data-alias');
                $.ajax({
                    type: 'POST',
                    url: '{/literal}{cms_action_url action='admin_ajax_set_active'}{literal}',
                    dataType: 'json',
                    data: ({
                        'alias': alias,
                        '{/literal}{$cms_secure_param_name}{literal}': '{/literal}{$smarty.get.$cms_secure_param_name}{literal}',
                        'module': '{/literal}{$mod->GetName()}{literal}',
                        'showtemplate': 'false',
                        'cg_activetab': 'mle_config',
                        'aAction': 'SyncData'
                    }),
                    complete: function (data) {
                        cms_alert(data.responseText);
                    }
                }).always(function () {})
            });
            
            $('.resetdata').live('click', function () {
            {/literal}
                var areyousure = "{$mod->Lang('areyousure_reset')}";
                {literal}
                var alias = $(this).attr('data-alias');
                var confirmBox = window.confirm(areyousure);
                if (confirmBox) {
                    $.ajax({
                        type: 'POST',
                        url: '{/literal}{cms_action_url action='admin_ajax_set_active'}{literal}',
                        dataType: 'json',
                        data: ({
                            'alias': alias,
                            '{/literal}{$cms_secure_param_name}{literal}': '{/literal}{$smarty.get.$cms_secure_param_name}{literal}',
                            'module': '{/literal}{$mod->GetName()}{literal}',
                            'showtemplate': 'false',
                            'cg_activetab': 'mle_config',
                            'aAction': 'ResetData'
                        }),
                        complete: function (data) {
                            cms_alert(data.responseText, 'Reset Alert');
                        }
                    }).always(function () {})
                }
            });
            
            /** remove events */
            $('.SetDefaultMle').bind('click', function (event) {
                var confirmBox = window.confirm(areyousure);
                if (confirmBox) {
                    $.myvars = {};
                    $.myvars.thisObj = $(this);
                    event.preventDefault();
                    var bvalue = $(this).attr('data-locale');

                    $.ajax({
                        type: 'POST',
                        url: '{/literal}{$ajaxSetDefaultMle}{literal}',
                        dataType: 'json',
                        data: ({
                            'bvalue': bvalue,
                            '{/literal}{$cms_secure_param_name}{literal}': '{/literal}{$smarty.get.$cms_secure_param_name}{literal}',
                            'module': '{/literal}{$mod->GetName()}{literal}',
                            'showtemplate': 'false',
                            'aAction': 'SetDefaultMle'
                        }),
                        complete: function (e) {
                            if (e.statusText == "OK") {
                                location.reload();
                            } else {
                                console.log(e);
                            }
                        }
                    });
                } else {
                    return false;
                } // end confirmBox
            })

        })
    </script>
{/literal}
