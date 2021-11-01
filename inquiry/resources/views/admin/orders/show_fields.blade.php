<!-- Id Field -->
<dt>{!! Form::label('id', 'Id:') !!}</dt>
<dd>{!! $order->id !!}</dd>

<!-- User Id Field -->
<dt>{!! Form::label('user_id', 'Customer Name:') !!}</dt>
<dd>{!! $order->customer->name !!}</dd>

<!-- Name Field -->
<dt>{!! Form::label('name', 'Name:') !!}</dt>
<dd>{!! $order->name !!}</dd>

<!-- Amount Field -->
<dt>{!! Form::label('amount', 'Amount:') !!}</dt>
<dd>{!! $order->amount !!}</dd>

<!-- Discount Field -->
<dt>{!! Form::label('discount', 'Discount:') !!}</dt>
<dd>{!! $order->discount !!}


<dt>{!! Form::label('send', 'Send Invoice:') !!}</dt>
<dd>
    <a href="{{url('admin/sendinvoice/'. $order->id)}}">
        <button>Send Invoice</button>
    </a>
</dd>


<dt>{!! Form::label('send', 'Send Coinbase:') !!}</dt>
<dd>
    <a href="{{url('admin/coinbase/'.$order->id)}}">
        <button>Using Coinbase</button>
    </a>
</dd>

<!-- Created At Field -->
<dt>{!! Form::label('created_at', 'Created At:') !!}</dt>
<dd>{!! $order->created_at !!}</dd>


{{--<div id="clonedInput1" class="clonedInput">--}}
{{--<div>--}}
{{--<label for="txtCategory" class="">Learning category <span class="requiredField">*</span></label>--}}
{{--<select class="" name="txtCategory[]" id="category1">--}}
{{--<option value="">Please select</option>--}}
{{--</select>--}}
{{--</div>--}}
{{--<div>--}}
{{--<label for="txtSubCategory" class="">Sub-category <span class="requiredField">*</span></label>--}}
{{--<select class="" name="txtSubCategory[]" id="subcategory1">--}}
{{--<option value="">Please select category</option>--}}
{{--</select>--}}
{{--</div>--}}
{{--<div>--}}
{{--<label for="txtSubSubCategory">Sub-sub-category <span class="requiredField">*</span></label>--}}
{{--<select name="txtSubSubCategory[]" id="subsubcategory1">--}}
{{--<option value="">Please select sub-category</option>--}}
{{--</select>--}}
{{--</div>--}}
{{--<div class="actions">--}}
{{--<button class="clone">Clone</button>--}}
{{--<button class="remove">Remove</button>--}}
{{--</div>--}}
{{--</div>--}}


<script>

    var regex = /^(.+?)(\d+)$/i;
    var cloneIndex = $(".clonedInput").length;

    function clone() {
        $(this).parents(".clonedInput").clone()
            .appendTo("body")
            .attr("id", "clonedInput" + cloneIndex)
            .find("*")
            .each(function () {
                var id = this.id || "";
                var match = id.match(regex) || [];
                if (match.length == 3) {
                    this.id = match[1] + (cloneIndex);
                }
            })
            .on('click', 'button.clone', clone)
            .on('click', 'button.remove', remove);
        cloneIndex++;
    }

    function remove() {
        $(this).parents(".clonedInput").remove();
    }

    $("button.clone").on("click", function () {
        console.log('ss');
        clone();
    });

    $("button.remove").on("click", function () {
        remove();
    });

</script>