<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@if(isset($back_btn) && ($current_step_id > 1 && $current_step_id <= 3))
    @if(backpack_user())
        <a  href= "{{backpack_url('response/'.$entry->getKey().'/backstep')}}" class="btn btn-primary btn-back" data-process = "backstep"><i class="fa fa-angle-left"></i>{{ trans('Go Back') }}</a>
    @else
        <a  href= "{{url('/response'.'/'.$entry->getKey().'/backstep')}}" class="btn btn-primary btn-back" data-process = "backstep"><i class="fa fa-angle-left"></i>{{ trans('Go Back') }}</a>
    @endif
@endif

@if(isset($current_step_id) && $current_step_id == 2)
        <a href= "javascript:void(0)" onclick="confirmation()" class="btn btn-primary btn-next">{{ trans('Proceed Next') }}<i class="fa fa-angle-right"></i></a>
@endif

@if(isset($current_step_id) && ($current_step_id == 1))
    <button type ="submit" class="btn btn-primary btn-next">{{ trans('Proceed Next') }}<i class="fa fa-angle-right"></i></button>
@elseif(isset($current_step_id) && ($current_step_id == 3))
    <button type ="submit" class="btn btn-primary btn-next"><i class="fa fa-database"></i>{{ trans('  Submit') }}</button>
@endif
<style>
    .swal-modal{
        width:700px;
        margin-bottom:20%;
    }
.swal-text {
    font-weight:bold;
  background-color: #FEFAE3;
  padding: 17px;
  border: 1px solid #F0E1A1;
  display: block;
  margin: 22px;
  text-align: center;
  color: #61534e;
}
</style>

<script>
    function confirmation(){

        let fields = $('form');
        let next_step = false;
        let next_step1 = false;
        let next_step2 = false;
        let next_step3 = false;
        let next_step4 = false;
        let next_step5 = false;
        let next_step6 = false;
        // fields validation
        fields.find("input:checkbox[name='occupation[]']").each(function () {
            $box = $(this);
            if ($(this).is(':checked')){
                next_step1 = true;
            }
        });
        fields.find("input:checkbox[name='exposure[]']").each(function () {
            $box = $(this);
            if ($(this).is(':checked')){
                next_step2 = true;
            }
        });
        fields.find("input:checkbox[name='safety_measure[]']").each(function () {
            $box = $(this);
            if ($(this).is(':checked')){
                next_step3 = true;
            }
        });
        fields.find("input:checkbox[name='habits[]']").each(function () {
            $box = $(this);
            if ($(this).is(':checked')){
                next_step4= true;
            }
        });
        fields.find("input:checkbox[name='health_condition[]']").each(function () {
            $box = $(this);
            if ($(this).is(':checked')){
                next_step5 = true;
            }
        });
        fields.find("input:checkbox[name='symptom[]']").each(function () {
            $box = $(this);
            if ($(this).is(':checked')){
                next_step6 = true;
            }
        });

        var comm = $('#community-situation').val();
        var eco = $('#economic-impact').val();

       if(next_step1 === true && next_step2 === true && next_step3 === true && next_step4 === true && next_step5 === true && next_step6 === true && (comm != "") && (eco != "")){
           next_step = true;
       }
       console.log(next_step);

        if (next_step === true) {
            swal({
            title: "",
            text: 'We are conducting research on the impact of this pandemic, hence would you like to help us by answering few more questions? If you have done it earlier, no need to repeat it.',
            buttons: {
            
                submit: {
                text: " Sorry !, only show my risk",
                value: 'submit',
                visible: true,
                className: "btn btn-warning",
                closeModal: true,
                },
                continue: {
                text: "Sure, Happy to proceed.",
                value: 'process_next',
                visible: true,
                className: "btn btn-success",
                } 
            },
            }).then((value) => {
                if(value == 'submit'){
                    var response_id = '<?php echo $entry->getKey(); ?>'
                    $.ajax({
                        url: '/response/'+response_id+'/updatefinalstep',
                        type: 'PUT',
                        success: function(response){
                                if(response.message == "success"){
                                    $('form').submit();
                                }
                        }
                    });
                }
                if(value == 'process_next'){
                        $('form').submit();
                }
            });
        }else{
            swal({
            title: "Alert !!",
            text: 'Please, fill the form to continue !!',
            icon : "warning",
            })

        }
    }


</script>

