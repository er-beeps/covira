$(document).ready(function() {
    $.urlParam = function(name) {
        try {

            var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
            return results[1] || 0;
        } catch {
            return null;
        }
    }
    $('#province').on('change', function() {
        var stateID = $(this).val();


        $('#district').append('<option value="">-- Loading...  --</option>');

        if (stateID) {
            $.ajax({
                url: '/district/' + stateID,
                type: "GET",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(data) {

                    if(data) {
                        $('#district').empty();
                        $('#local_level').empty();
                        $('#district').focus;
                        $('#district').append('<option value="">-- जिल्ला छान्नुहोस्  --</option>');
                        var selected_id = $.urlParam("district");

                        $.each(data, function(key, value) {
                            var selected = "";
                            if (selected_id == value.id) {
                                selected = "SELECTED";
                            }

                            $('select[name="district"]').append('<option class="form-control nepali_td" value="' + value.id + '" ' + selected + '>' + value.code + '-' + value.name_lc + '-' + value.name_en + '</option>');
                            if (selected == "") {
                                $("#district").trigger("change");
                                $("#local_level").trigger("change");
                            }
                        });
                    } else {
                        $('#district').empty();
                        $('#local_level').empty();
                    }
                }
            });
        } else {
            $('#district').empty();
            $('#local_level').empty();
        }
    });

    $('#district').on('change', function() {
        var districtID = $(this).val();
        if (districtID) {
            $('#local_level').append('<option value="">-- Loading...  --</option>');
            $.ajax({
                url: '/local_level/' + districtID,
                type: "GET",
                data: {
                    "_token": "{{ csrf_token() }}"
                },

                dataType: "json",
                success: function(data) {
                    if (data) {
                        $('#local_level').empty();
                        $('#local_level').focus;
                        $('#local_level').append('<option value="">-- स्थानीय तह  छान्नुहोस् --</option>');
                        var selected_id = $.urlParam("local_level");
                        $.each(data, function(key, value) {
                            var selected = "";
                            if (selected_id == value.id) {
                                selected = "SELECTED";
                            }
                            $('select[name="local_level"]').append('<option class="form-control nepali_td" value="' + value.id + '" ' + selected + '>' + value.code + '-' + value.name_lc + '-' + value.name_en + '</option>');
                            if (selected == "") {
                                $("#local_level").trigger("change");
                            }
                        });
                    } else {
                        $('#local_level').empty();
                    }
                }
            });
        } else {
            $('#local_level').empty();
        }
    });
    $("#province").trigger("change");


    $('#category_id').on('change', function() {
        var stateID = $(this).val();
        if (stateID) {
            $('#sub_category_id').append('<option value="">-- Loading...  --</option>');
            $.ajax({
                url: '/sub_category/' + stateID,
                type: "GET",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(data) {

                    if (data) {
                        $('#sub_category_id').empty();

                        $('#sub_category_id').focus;
                        $('#sub_category_id').append('<option value="">-- Select Sub Category --</option>');
                        var selected_id = $.urlParam("sub_category_id");
                        $.each(data, function(key, value) {
                            var selected = "";
                            if (selected_id == value.id) {
                                selected = "SELECTED";
                            }
                            $('select[name="sub_category_id"]').append('<option class="form-control nepali_td" value="' + value.id + '" ' + selected + '>' + value.code + '-' + value.name_lc + '-' + value.name_en + '</option>');
                            if (selected == "") {
                                $("#sub_category_id").trigger("change");
                                
                            }
                        });
                    } else {
                        $('#sub_category_id').empty();
                        
                    }
                }
            });
        } else {
            $('#sub_category_id').empty();
            
        }
    });
    $("#category_id").trigger("change");

    //reporting_interval
    $('#reporting_interval_id').on('change', function() {
        var stateID = $(this).val();
        if (stateID) {
            $('#month_id').append('<option value="">-- Loading...  --</option>');
            $.ajax({
                url: '/month_id/' + stateID,
                type: "GET",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    if (data) {
                        $('#month_id').empty();
                        $('#month_id').focus;
                        $('#month_id').append('<option value="">-- Select Time Of Report --</option>');
                        var selected_id = $.urlParam("month_id");
                        $.each(data, function(key, value) {
                            var selected = "";
                            if (selected_id == value.id) {
                                selected = "SELECTED";
                            }
                            $('select[name="month_id"]').append('<option class="form-control nepali_td" value="' + value.id + '" ' + selected + '>' + value.code + '-' + value.name_en + '</option>');
                            if (selected == "SELECTED") {
                                $("#month_id").trigger("change");
                            }
                        });
                    } else {
                        $('#month_id').empty();
                    }
                }
            });
        } else {
            $('#month_id').empty();
        }
    });
    $("#reporting_interval_id").trigger("change");
});


$('#project_id').on('change', function() {
    var projectid = $(this).val();
    // alert(projectid);
    if (projectid) {
        $.ajax({
            url: '/unit_type/' + projectid,
            type: "GET",
            data: {
                "_token": "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                if (data) {
                    $('#unit_type').append(document.getElementById('unit_type').value = data[0].name_lc);
                    $('#quantity').append(document.getElementById('quantity').value = data[0].quantity);
                    $('#weightage').append(document.getElementById('weightage').value = data[0].weightage);
                    $('#budget').append(document.getElementById('budget').value = data[0].project_cost);
                } else {
                    alert('error');
                }
            }
        });
    } else {
        $('#unit_type').empty();
    }
});