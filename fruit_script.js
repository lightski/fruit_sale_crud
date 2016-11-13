/*
 * fruit_script.js- javascript helper functions for fruit counter
 *  NOTE: product_arr courtesy page_defs.php->$fruit_items
 */
$(document).ready(function(){
    // alert(JSON.stringify(product_arr));
    // running total on order entry page
    if ($(document).attr('title').substring(22) == 'Order Entry'){
        var total_items = 0;
        var total_check = 0.00;
        // loop through inputs to properly set initial totals [in case of edit a record]
        $("input[type='number']").each(function(){ 
            var end = $(this).attr('name').length - 1;
            var kind = $(this).attr('name').substring(6,end);
            product_arr[kind].amount = parseInt($(this).val());
            total_items += product_arr[kind].amount;
            total_check += (product_arr[kind].price * product_arr[kind].amount);
        });
        $("input[name='total_items']").val(total_items);
        $("input[name='total_check']").val("$" + total_check);

        // when inputs change, update total items and check
        $("input[type='number']").change(function(){ 
            //  change works by deciding if increase or decrease
            //   then offestting totals by the value of the increase or decrease
            var new_quantity = parseInt($(this).val());
            var end = $(this).attr('name').length - 1;
            var kind = $(this).attr('name').substring(6,end);
            if (product_arr[kind].amount < new_quantity){
                total_items += (new_quantity - product_arr[kind].amount);
                total_check += (product_arr[kind].price * (new_quantity - product_arr[kind].amount));
            } else if (product_arr[kind].amount > new_quantity){
                total_items -= (product_arr[kind].amount - new_quantity);
                total_check -= (product_arr[kind].price * (product_arr[kind].amount - new_quantity));
            }
            // alert('items,quant: ' + total_items + " "+ total_check);
            product_arr[kind].amount = new_quantity;
            $("input[name='total_items']").val(total_items);
            $("input[name='total_check']").val("$" + total_check);
        });
    }
});
