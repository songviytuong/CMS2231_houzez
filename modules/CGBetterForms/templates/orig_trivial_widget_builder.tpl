<script>
$(function(){
   {*
   This template requires jquery,  it should be initialized somewhere in the head of your page template (not the body) in order to use this template as is.
   
   this is a trivial example of calculating price in javascript/jquery.
   you could use ajax, or any other means to get get initial data, populate the form
   and to calculate the price.
   *}
   var base_price = 10.0;
   var el_size = $('#widget_size');
   var el_color = $('#widget_color');
   var el_shape = $('#widget_shape');
   var el_price = $('#widget_price');

   function calc_price() {
      var price = base_price;
      price += $('option:selected',el_size).data('price');
      price += $('option:selected',el_color).data('price');
      price += $('option:selected',el_shape).data('price');
      el_price.val(price);
   }

   el_size.change(calc_price);
   el_color.change(calc_price);
   el_shape.change(calc_price);
   el_size.trigger('change');
});
</script>

{cgbf_form_errors assign='errors'}
{if !empty($errors)}
  <ul class="alert alert-danger">
  {foreach $errors as $err}
    <li>{$err}</li>
  {/foreach}
  </ul>
{/if}

<h3>Trivial Widget Builder</h3>
<form id="simple_calculator">
<div class="form-group">
   <label class="col-sm-2">Widget Size:
      <select id="widget_size" name="widget_size" class="col-sm-9" data-cgbf-selected="{$form_data->widget_size|default:'medium'}">
         <option value="small" data-price=0>Small</option>
         <option value="medium" data-price=1>Medium</option>
         <option value="large" data-price=2>Large</option>
         <option value="XL" data-price=3>XL</option>
         <option value="XXL" data-price=4>XXL</option>
      </select>
   </label>
</div>
<div class="form-group">
   <label class="col-sm-2">Widget Color:
      <select id="widget_color" name="widget_color" class="col-sm-9" data-cgbf-selected="{$form_data->widget_color|default:'red'}">
         <option value="black" data-price=0>Black</option>
         <option value="white" data-price=0>White</option>
         <option value="red" data-price=1>Red</option>
         <option value="green" data-price=2>Green</option>
         <option value="blue" data-price=3>Blue</option>
      </select>
   </label>
</div>
<div class="form-group">
   <label class="col-sm-2">Widget Color:
      <select id="widget_shape" name="widget_shape" class="col-sm-9" data-cgbf-selected="{$form_data->widget_shape|default:'round'}">
         <option value="square" data-price=0>Square</option>
         <option value="round" data-price=0>Circular</option>
         <option value="oval" data-price=1>Oval</option>
         <option value="hex" data-price=2>Hexagon</option>
         <option value="oct" data-price=3>Octagon</option>
      </select>
   </label>
</div>
<div class="form-group">
  <label class="col-sm-2">Final Price:
     <input type="text" id="widget_price" disabled>{* name omitted intentionally, so that calculated data is not submitted. *}
  </label>
</div>
<div class="row">
   <button>Submit</button>
</div>
</form>
