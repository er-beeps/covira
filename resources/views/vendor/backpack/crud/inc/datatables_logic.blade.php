  <!-- DATA TABLES SCRIPT -->
  <script type="text/javascript" src="{{ asset('packages/datatables.net/js/jquery.dataTables.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('packages/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('packages/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('packages/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('packages/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('packages/datatables.net-fixedheader-bs4/js/fixedHeader.bootstrap4.min.js') }}"></script>
  <script type="text/javascript" src="{{asset('js/fixedColumns.min.js')}}"></script>  

  <script>
    @if ($crud->getPersistentTable())

        var saved_list_url = localStorage.getItem('{{ str_slug($crud->getRoute()) }}_list_url');

        //check if saved url has any parameter or is empty after clearing filters.

        if (saved_list_url && saved_list_url.indexOf('?') < 1) {
            var saved_list_url = false;
        }else{
            var persistentUrl = saved_list_url+'&persistent-table=true';
        }

    var arr =  window.location.href.split('?');
        //check if url has parameters.
        if (arr.length > 1 && arr[1] !== '') {
                // IT HAS! Check if it is our own persistence redirect.
                if (window.location.search.indexOf('persistent-table=true') < 1) {
                    // IF NOT: we don't want to redirect the user.
                    saved_list_url = false;
                }
        }

    @if($crud->getPersistentTableDuration())
        var saved_list_url_time = localStorage.getItem('{{ str_slug($crud->getRoute()) }}_list_url_time');

        if (saved_list_url_time) {
            var $current_date = new Date();
            var $saved_time = new Date(parseInt(saved_list_url_time));
            $saved_time.setMinutes($saved_time.getMinutes() + {{$crud->getPersistentTableDuration()}});

            //if the save time is not expired we force the filter redirection.
            if($saved_time > $current_date) {
                if (saved_list_url && persistentUrl!=window.location.href) {
                    window.location.href = persistentUrl;
                }
            } else {  <!-- DATA TABLES SCRIPT -->
  <script type="text/javascript" src="{{ asset('packages/datatables.net/js/jquery.dataTables.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('packages/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('packages/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('packages/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('packages/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('packages/datatables.net-fixedheader-bs4/js/fixedHeader.bootstrap4.min.js') }}"></script>
  <!-- <script type="text/javascript" src="{{ asset('packages/datatables.net/js/dataTables.rowReorder.min.js') }}"></script> -->
  <script type="text/javascript" src="{{asset('js/fixedColumns.min.js')}}"></script>  
    

  
  <script>
    @if ($crud->getPersistentTable())

        var saved_list_url = localStorage.getItem('{{ str_slug($crud->getRoute()) }}_list_url');

        //check if saved url has any parameter or is empty after clearing filters.

        if (saved_list_url && saved_list_url.indexOf('?') < 1) {
            var saved_list_url = false;
        }else{
            var persistentUrl = saved_list_url+'&persistent-table=true';
        }

    var arr =  window.location.href.split('?');
        //check if url has parameters.
        if (arr.length > 1 && arr[1] !== '') {
                // IT HAS! Check if it is our own persistence redirect.
                if (window.location.search.indexOf('persistent-table=true') < 1) {
                    // IF NOT: we don't want to redirect the user.
                    saved_list_url = false;
                }
        }

    @if($crud->getPersistentTableDuration())
        var saved_list_url_time = localStorage.getItem('{{ str_slug($crud->getRoute()) }}_list_url_time');

        if (saved_list_url_time) {
            var $current_date = new Date();
            var $saved_time = new Date(parseInt(saved_list_url_time));
            $saved_time.setMinutes($saved_time.getMinutes() + {{$crud->getPersistentTableDuration()}});

            //if the save time is not expired we force the filter redirection.
            if($saved_time > $current_date) {
                if (saved_list_url && persistentUrl!=window.location.href) {
                    window.location.href = persistentUrl;
                }
            } else {
            //persistent table expired, let's not redirect the user
                saved_list_url = false;
            }
        }

    @endif
        if (saved_list_url && persistentUrl!=window.location.href) {
            window.location.href = persistentUrl;
        }
    @endif

    var crud = {
      exportButtons: JSON.parse('{!! json_encode($crud->get('list.export_buttons')) !!}'),
      functionsToRunOnDataTablesDrawEvent: [],
      addFunctionToDataTablesDrawEventQueue: function (functionName) {
          if (this.functionsToRunOnDataTablesDrawEvent.indexOf(functionName) == -1) {
          this.functionsToRunOnDataTablesDrawEvent.push(functionName);
        }
      },
      responsiveToggle: function(dt) {
          $(dt.table().header()).find('th').toggleClass('all');
          dt.responsive.rebuild();
          dt.responsive.recalc();
      },
      executeFunctionByName: function(str, args) {
        var arr = str.split('.');
        var fn = window[ arr[0] ];

        for (var i = 1; i < arr.length; i++)
        { fn = fn[ arr[i] ]; }
        fn.apply(window, args);
      },
      updateUrl : function (new_url) {
         new_url = new_url.replace('/search', '');
         window.history.pushState({}, '', new_url);
         localStorage.setItem('{{ str_slug($crud->getRoute()) }}_list_url', new_url);
      },

    //----------Added row reorder configuration-------------//
      dataTableConfiguration: {
         
        

           // rowReorder:true,
//         columnDefs: [
    
// ],
        // rowReorder: {dataSrc: 'id',
        // },
               
        @if ($crud->getResponsiveTable())
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal( {
                        header: function ( row ) {
                            // show the content of the first column
                            // as the modal header
                            // var data = row.data();
                            // return data[0];
                            return '';
                        }
                    } ),
                    renderer: function ( api, rowIdx, columns ) {
                    var data = $.map( columns, function ( col, i ) {
                        var columnHeading = crud.table.columns().header()[col.columnIndex];

                        // hide columns that have VisibleInModal false
                        if ($(columnHeading).attr('data-visible-in-modal') == 'false') {
                            return '';
                        }

                        return '<tr data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
                                    '<td style="vertical-align:top; border:none;"><strong>'+col.title.trim()+':'+'<strong></td> '+
                                    '<td style="padding-left:10px;padding-bottom:10px; border:none;">'+col.data+'</td>'+
                                '</tr>';
                    } ).join('');

                    return data ?
                        $('<table class="table table-striped mb-0">').append( '<tbody>' + data + '</tbody>' ) :
                        false;
                    },
                }
            },
            fixedHeader: true,
        @else
            responsive: false,
            scrollX: true,
            // scrollY:"100vh",
            scrollY:true,
            scrollCollapse: true,
            fixedColumns: true,
            paging:true,
        @endif
        
        @if ($crud->getPersistentTable()) //restore datatable state on reload
            deferRender:true,                   //only render visible part of dataTable
            scroller:true,
            stateSave: true,
            /*
                if developer forced field into table 'visibleInTable => true' we make sure when saving datatables state
                that it reflects the developer decision.
            */

            stateSaveParams: function(settings, data) {
                localStorage.setItem('{{ str_slug($crud->getRoute()) }}_list_url_time', data.time);
                data.columns.forEach(function(item, index) {
                    var columnHeading = crud.table.columns().header()[index];
                        if ($(columnHeading).attr('data-visible-in-table') == 'true') {
                            return item.visible = true;
                        }
                });
            },
            @if($crud->getPersistentTableDuration())
                stateLoadParams: function(settings, data) {
                    var $saved_time = new Date(data.time);
                    var $current_date = new Date();

                    $saved_time.setMinutes($saved_time.getMinutes() + {{$crud->getPersistentTableDuration()}});

                    //if the save time as expired we force datatabled to clear localStorage
                    if($saved_time < $current_date) {
                        if (localStorage.getItem('{{ str_slug($crud->getRoute())}}_list_url')) {
                            localStorage.removeItem('{{ str_slug($crud->getRoute()) }}_list_url');
                        }
                        if (localStorage.getItem('{{ str_slug($crud->getRoute())}}_list_url_time')) {
                            localStorage.removeItem('{{ str_slug($crud->getRoute()) }}_list_url_time');
                        }
                    return false;
                    }
                },
            @endif
        @endif
        fixedColumns:{                  
            leftColumns: 0,
            rightColumns: 1,    //fixing action column
        },
        fixedHeader: {
            header: false,
            footer: false,
        },
        autoWidth:false,
        pageLength: {{ $crud->getDefaultPageLength() }},
        lengthMenu: @json($crud->getPageLengthMenu()),
        /* Disable initial sort */
        aaSorting: [],
        language: {
              "emptyTable":     "{{ trans('backpack::crud.emptyTable') }}",
              "info":           "{{ trans('backpack::crud.info') }}",
              "infoEmpty":      "{{ trans('backpack::crud.infoEmpty') }}",
              "infoFiltered":   "{{ trans('backpack::crud.infoFiltered') }}",
              "infoPostFix":    "{{ trans('backpack::crud.infoPostFix') }}",
              "thousands":      "{{ trans('backpack::crud.thousands') }}",
              "lengthMenu":     "{{ trans('backpack::crud.lengthMenu') }}",
              "loadingRecords": "{{ trans('backpack::crud.loadingRecords') }}",
              "processing":     "<img src='{{ asset('packages/backpack/crud/img/ajax-loader.gif') }}' alt='{{ trans('backpack::crud.processing') }}'>",
              "search":         "<span class='d-none d-sm-inline'>{{ trans('backpack::crud.search') }}</span>",
              "zeroRecords":    "{{ trans('backpack::crud.zeroRecords') }}",
              "paginate": {
                  "first":      "{{ trans('backpack::crud.paginate.first') }}",
                  "last":       "{{ trans('backpack::crud.paginate.last') }}",
                  "next":       ">",
                  "previous":   "<"
              },
              "aria": {
                  "sortAscending":  "{{ trans('backpack::crud.aria.sortAscending') }}",
                  "sortDescending": "{{ trans('backpack::crud.aria.sortDescending') }}"
              },
              "buttons": {
                  "copy":   "{{ trans('backpack::crud.export.copy') }}",
                  "excel":  "{{ trans('backpack::crud.export.excel') }}",
                  "csv":    "{{ trans('backpack::crud.export.csv') }}",
                  "pdf":    "{{ trans('backpack::crud.export.pdf') }}",
                  "print":  "{{ trans('backpack::crud.export.print') }}",
                  "colvis": "{{ trans('backpack::crud.export.column_visibility') }}"
              },
          },
          processing: true,
          serverSide: true,
          ajax: {
              "url": "{!! url($crud->route.'/search').'?'.Request::getQueryString() !!}",
              "type": "POST"
          },
          dom:
            "<'row hidden'<'col-sm-6 hidden-xs'i><'col-sm-6 hidden-print'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row mt-2 '<'col-sm-6 col-md-4'l><'col-sm-2 col-md-4 text-center'B><'col-sm-6 col-md-4 hidden-print'p>>",

          drawCallback: function( settings ) {
              if($('.DTFC_RightWrapper').css('width') !== undefined){
                setTimeout(function(){ 
                  $('.DTFC_RightWrapper').css('width', (parseFloat($('.DTFC_RightWrapper').css('width').replace('px','')) + 17) + "px");
                }, 400);
              }
          }
      }
  }
  </script>

  <!-- Styling for datatable elements -->
  <style>
      /* set vertical and horizontal scrollbar in the datatables*/
    .dataTables_scrollBody{overflow-y:scroll !important; overflow-x:scroll !important; } 

        /* Hide Scroll bar in action column*/
    .DTFC_RightBodyLiner{
      overflow-y:hidden !important;
      overflow-x: hidden !important;
    }

    /* Adjusting Position of action column */
    .DTFC_RightFootWrapper{
        margin-top:-6px !important;
    }
    div.DTFC_RightBodyWrapper {
        top:-6px !important;
    }
    
  </style>

  @include('crud::inc.export_buttons')

  <script type="text/javascript">

    function {{$controller}}_item_edit_click(){
        var target = event.target;
        if(target.href == undefined){
            target = target.closest("a");
        }

        $.fancybox.open({
            //width: 400,
            //width : "{{$crud->get('create.fancybox.width')}}",
            // height: 400,
            autoSize: false,
            src: $(target).attr("data-src"),
            type: 'ajax',
            afterClose : function(){
                console.log("afterClose");
            },
          
            //beforeShow : function(){
            //   debugger;
            //    $(".fancybox-content").css("width", "{{$crud->get('create.fancybox.width')}}");
            //},
            //NOTE: if multiple datatables in single page change this.
            datatable:crud.table
        });
    }
    function {{$controller}}_item_add_click(){
        {{$controller}}_item_edit_click();
    }


    jQuery(document).ready(function($) {

    
      crud.table = $("#crudTable").DataTable(crud.dataTableConfiguration);

      
    //   crud.table.rowReorder.enable();
    //   //-----------------------jQUERY FOR THE ROW REORDERING----------------------------------------//
    //   crud.table.on( 'row-reorder', function ( e, diff, edit ) {
    //     var result = 'Reorder started on row: '+edit.triggerRow.data()[1]+'<br>';
        
    //     for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
    //         var rowData = crud.table.row( diff[i].node ).data();
 
    //         result += rowData[1]+' updated to be in position '+
    //             diff[i].newData+' (was '+diff[i].oldData+')<br>';
    //     }

    //     console.log(diff);
    //     // saveReorder(diff,rowData[1]);

 
    //     // $('#result').html( 'Event result:<br>'+result );
    // }
    // );
//--------------------------------------------------------
//      

    //Save after reorder
    // function saveReorder(diff,rowData){
    //   var positions = [];
      
      
      
    //   diff.forEach(function(item, index, array) {
    //     var newPos = item.newPosition
    //     var oldPos = item.oldPosition
    //     var ind = index

    //     positions.push({
    //       newpos:newPos,
    //       oldpos:oldPos,
    //       index: ind
    //     });

    //   });
      
    //   //ajax call to alter display order
    //   $.ajax({
    //     type: "POST",
    //     url: "/admin/reorderbydisplayorder",
    //     data: {positions:positions,rowData:rowData},
    //     success: function(response) {
    //         if (response.message == "success") {
                
    //         }
    //     },
    //     error: function(error) {}
    //   })
      
    // }

    //  Save Scroll Position to session storage
      if(sessionStorage.getItem('scrollPosition')!==undefined||sessionStorage.getItem('scrollPosition')!==null)
      { 
        
      sessionStorage.setItem("sp", sessionStorage.getItem('scrollPosition'));
      // sessionStorage.sp = sessionStorage.getItem('scrollPosition');
       }
       $('.dataTables_scrollBody').scroll(function(){
       sessionStorage.setItem("scrollPosition", $('.dataTables_scrollBody').scrollTop());
      }); 

      // move search bar
      $("#crudTable_filter").appendTo($('#datatable_search_stack' ));
      $("#crudTable_filter input").removeClass('form-control-sm');

      // move "showing x out of y" info to header
      $("#datatable_info_stack").html($('#crudTable_info'));

      // move the bottom buttons before pagination
      $("#bottom_buttons").insertBefore($('#crudTable_wrapper .row:last-child' ));

      // override ajax error message
      $.fn.dataTable.ext.errMode = 'none';
      $('#crudTable').on('error.dt', function(e, settings, techNote, message) {
          new Noty({
              type: "error",
              text: "<strong>{{ trans('backpack::crud.ajax_error_title') }}</strong><br>{{ trans('backpack::crud.ajax_error_text') }}"
          }).show();
      });

      // make sure AJAX requests include XSRF token
      $.ajaxPrefilter(function(options, originalOptions, xhr) {
          var token = $('meta[name="csrf_token"]').attr('content');

          if (token) {
                return xhr.setRequestHeader('X-XSRF-TOKEN', token);
          }
      });

      // on DataTable draw event run all functions in the queue
      // (eg. delete and details_row buttons add functions to this queue)
      $('#crudTable').on( 'draw.dt',   function () {
          //Restore Scroll bar position from session storage
        $('.dataTables_scrollBody').scrollTop(sessionStorage.getItem('sp'));

         crud.functionsToRunOnDataTablesDrawEvent.forEach(function(functionName) {
            crud.executeFunctionByName(functionName);
         });
      } ).dataTable();

      // when datatables-colvis (column visibility) is toggled
      // rebuild the datatable using the datatable-responsive plugin
      $('#crudTable').on( 'column-visibility.dt',   function (event) {
         crud.table.responsive.rebuild();
      } ).dataTable();

      @if ($crud->getResponsiveTable())
        // when columns are hidden by reponsive plugin,
        // the table should have the has-hidden-columns class
        crud.table.on( 'responsive-resize', function ( e, datatable, columns ) {
            if (crud.table.responsive.hasHidden()) {
              $("#crudTable").removeClass('has-hidden-columns').addClass('has-hidden-columns');
             } else {
              $("#crudTable").removeClass('has-hidden-columns');
             }
        } );
      @else
        // make sure the column headings have the same width as the actual columns
        // after the user manually resizes the window
        var resizeTimer;
        function resizeCrudTableColumnWidths() {
          clearTimeout(resizeTimer);
          resizeTimer = setTimeout(function() {
            // Run code here, resizing has "stopped"
            crud.table.columns.adjust();
          }, 250);
        }
        $(window).on('resize', function(e) {
          resizeCrudTableColumnWidths();
        });
        $(document).on('expanded.pushMenu', function(e) {
          resizeCrudTableColumnWidths();
        });
        $(document).on('collapsed.pushMenu', function(e) {
          resizeCrudTableColumnWidths();
        });
      @endif

    });
  </script>

  @include('crud::inc.details_row_logic')

            //persistent table expired, let's not redirect the user
                saved_list_url = false;
            }
        }

    @endif
        if (saved_list_url && persistentUrl!=window.location.href) {
            window.location.href = persistentUrl;
        }
    @endif

    var crud = {
      exportButtons: JSON.parse('{!! json_encode($crud->get('list.export_buttons')) !!}'),
      functionsToRunOnDataTablesDrawEvent: [],
      addFunctionToDataTablesDrawEventQueue: function (functionName) {
          if (this.functionsToRunOnDataTablesDrawEvent.indexOf(functionName) == -1) {
          this.functionsToRunOnDataTablesDrawEvent.push(functionName);
        }
      },
      responsiveToggle: function(dt) {
          $(dt.table().header()).find('th').toggleClass('all');
          dt.responsive.rebuild();
          dt.responsive.recalc();
      },
      executeFunctionByName: function(str, args) {
        var arr = str.split('.');
        var fn = window[ arr[0] ];

        for (var i = 1; i < arr.length; i++)
        { fn = fn[ arr[i] ]; }
        fn.apply(window, args);
      },
      updateUrl : function (new_url) {
        new_url = new_url.replace('/search', '');
        window.history.pushState({}, '', new_url);
        localStorage.setItem('{{ str_slug($crud->getRoute()) }}_list_url', new_url);
      },
      dataTableConfiguration: {

        @if ($crud->getResponsiveTable())
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal( {
                    header: function ( row ) {
                        // show the content of the first column
                        // as the modal header
                        // var data = row.data();
                        // return data[0];
                        return '';
                    }
                } ),
                renderer: function ( api, rowIdx, columns ) {

                  var data = $.map( columns, function ( col, i ) {
                      var columnHeading = crud.table.columns().header()[col.columnIndex];

                      // hide columns that have VisibleInModal false
                      if ($(columnHeading).attr('data-visible-in-modal') == 'false') {
                        return '';
                      }

                      return '<tr data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
                                '<td style="vertical-align:top; border:none;"><strong>'+col.title.trim()+':'+'<strong></td> '+
                                '<td style="padding-left:10px;padding-bottom:10px; border:none;">'+col.data+'</td>'+
                              '</tr>';
                  } ).join('');

                  return data ?
                      $('<table class="table table-striped mb-0">').append( '<tbody>' + data + '</tbody>' ) :
                      false;
                },
            }
        },
        fixedHeader: true,
        @else
        responsive: false,
        scrollX: true,
        scrollCollapse: true,
        fixedColumns: true,
        paging:true,
        @endif

        @if ($crud->getPersistentTable())
        deferRender:true,
        stateSave: true,
        scroller:true,
        /*
            if developer forced field into table 'visibleInTable => true' we make sure when saving datatables state
            that it reflects the developer decision.
        */

        stateSaveParams: function(settings, data) {

            localStorage.setItem('{{ str_slug($crud->getRoute()) }}_list_url_time', data.time);

            data.columns.forEach(function(item, index) {
                var columnHeading = crud.table.columns().header()[index];
                    if ($(columnHeading).attr('data-visible-in-table') == 'true') {
                        return item.visible = true;
                    }
            });
        },
        @if($crud->getPersistentTableDuration())
        stateLoadParams: function(settings, data) {
            var $saved_time = new Date(data.time);
            var $current_date = new Date();

            $saved_time.setMinutes($saved_time.getMinutes() + {{$crud->getPersistentTableDuration()}});

            //if the save time as expired we force datatabled to clear localStorage
            if($saved_time < $current_date) {
                if (localStorage.getItem('{{ str_slug($crud->getRoute())}}_list_url')) {
                    localStorage.removeItem('{{ str_slug($crud->getRoute()) }}_list_url');
                }
                if (localStorage.getItem('{{ str_slug($crud->getRoute())}}_list_url_time')) {
                    localStorage.removeItem('{{ str_slug($crud->getRoute()) }}_list_url_time');
                }
               return false;
            }
        },
        @endif
        @endif
        fixedColumns:{                  
            leftColumns: 0,
            rightColumns: 1,    //fixing action column
        },
        autoWidth: false,
        pageLength: {{ $crud->getDefaultPageLength() }},
        lengthMenu: @json($crud->getPageLengthMenu()),
        /* Disable initial sort */
        aaSorting: [],
        language: {
              "emptyTable":     "{{ trans('backpack::crud.emptyTable') }}",
              "info":           "{{ trans('backpack::crud.info') }}",
              "infoEmpty":      "{{ trans('backpack::crud.infoEmpty') }}",
              "infoFiltered":   "{{ trans('backpack::crud.infoFiltered') }}",
              "infoPostFix":    "{{ trans('backpack::crud.infoPostFix') }}",
              "thousands":      "{{ trans('backpack::crud.thousands') }}",
              "lengthMenu":     "{{ trans('backpack::crud.lengthMenu') }}",
              "loadingRecords": "{{ trans('backpack::crud.loadingRecords') }}",
              "processing":     "<img src='{{ asset('packages/backpack/crud/img/ajax-loader.gif') }}' alt='{{ trans('backpack::crud.processing') }}'>",
              "search":         "<span class='d-none d-sm-inline'>{{ trans('backpack::crud.search') }}</span>",
              "zeroRecords":    "{{ trans('backpack::crud.zeroRecords') }}",
              "paginate": {
                  "first":      "{{ trans('backpack::crud.paginate.first') }}",
                  "last":       "{{ trans('backpack::crud.paginate.last') }}",
                  "next":       ">",
                  "previous":   "<"
              },
              "aria": {
                  "sortAscending":  "{{ trans('backpack::crud.aria.sortAscending') }}",
                  "sortDescending": "{{ trans('backpack::crud.aria.sortDescending') }}"
              },
              "buttons": {
                  "copy":   "{{ trans('backpack::crud.export.copy') }}",
                  "excel":  "{{ trans('backpack::crud.export.excel') }}",
                  "csv":    "{{ trans('backpack::crud.export.csv') }}",
                  "pdf":    "{{ trans('backpack::crud.export.pdf') }}",
                  "print":  "{{ trans('backpack::crud.export.print') }}",
                  "colvis": "{{ trans('backpack::crud.export.column_visibility') }}"
              },
          },
          processing: true,
          serverSide: true,
          ajax: {
              "url": "{!! url($crud->route.'/search').'?'.Request::getQueryString() !!}",
              "type": "POST"
          },
          dom:
            "<'row hidden'<'col-sm-6 hidden-xs'i><'col-sm-6 hidden-print'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row mt-2 '<'col-sm-6 col-md-4'l><'col-sm-2 col-md-4 text-center'B><'col-sm-6 col-md-4 hidden-print'p>>",

            drawCallback: function( settings ) {
              if($('.DTFC_RightWrapper').css('width') !== undefined){
                setTimeout(function(){ 
                  $('.DTFC_RightWrapper').css('width', (parseFloat($('.DTFC_RightWrapper').css('width').replace('px','')) + 17) + "px");
                }, 400);
              }
          }
      }
  }
  </script>

   <!-- Styling for datatable elements -->
  <style>
      /* set vertical and horizontal scrollbar in the datatables*/
    .dataTables_scrollBody{overflow-y:scroll !important; overflow-x:scroll !important; } 

        /* Hide Scroll bar in action column*/
    .DTFC_RightBodyLiner{
      overflow-y:hidden !important;
      overflow-x: hidden !important;
    }

    /* Adjusting Position of action column */
    .DTFC_RightFootWrapper{
        margin-top:-6px !important;
    }
    div.DTFC_RightBodyWrapper {
        top:-6px !important;
    }
    </style>

  @include('crud::inc.export_buttons')

  <script type="text/javascript">
    jQuery(document).ready(function($) {

      crud.table = $("#crudTable").DataTable(crud.dataTableConfiguration);

  //  Save Scroll Position to session storage
      if(sessionStorage.getItem('scrollPosition')!==undefined||sessionStorage.getItem('scrollPosition')!==null)
      { 
        
      sessionStorage.setItem("sp", sessionStorage.getItem('scrollPosition'));
      // sessionStorage.sp = sessionStorage.getItem('scrollPosition');
       }
       $('.dataTables_scrollBody').scroll(function(){
       sessionStorage.setItem("scrollPosition", $('.dataTables_scrollBody').scrollTop());
      });
      
      // move search bar
      $("#crudTable_filter").appendTo($('#datatable_search_stack' ));
      $("#crudTable_filter input").removeClass('form-control-sm');

      // move "showing x out of y" info to header
      $("#datatable_info_stack").html($('#crudTable_info'));

      // move the bottom buttons before pagination
      $("#bottom_buttons").insertBefore($('#crudTable_wrapper .row:last-child' ));

      // override ajax error message
      $.fn.dataTable.ext.errMode = 'none';
      $('#crudTable').on('error.dt', function(e, settings, techNote, message) {
          new Noty({
              type: "error",
              text: "<strong>{{ trans('backpack::crud.ajax_error_title') }}</strong><br>{{ trans('backpack::crud.ajax_error_text') }}"
          }).show();
      });

      // make sure AJAX requests include XSRF token
      $.ajaxPrefilter(function(options, originalOptions, xhr) {
          var token = $('meta[name="csrf_token"]').attr('content');

          if (token) {
                return xhr.setRequestHeader('X-XSRF-TOKEN', token);
          }
      });

      // on DataTable draw event run all functions in the queue
      // (eg. delete and details_row buttons add functions to this queue)
      $('#crudTable').on( 'draw.dt',   function () {
         crud.functionsToRunOnDataTablesDrawEvent.forEach(function(functionName) {
            crud.executeFunctionByName(functionName);
         });
      } ).dataTable();

      // when datatables-colvis (column visibility) is toggled
      // rebuild the datatable using the datatable-responsive plugin
      $('#crudTable').on( 'column-visibility.dt',   function (event) {
         crud.table.responsive.rebuild();
      } ).dataTable();

      @if ($crud->getResponsiveTable())
        // when columns are hidden by reponsive plugin,
        // the table should have the has-hidden-columns class
        crud.table.on( 'responsive-resize', function ( e, datatable, columns ) {
            if (crud.table.responsive.hasHidden()) {
              $("#crudTable").removeClass('has-hidden-columns').addClass('has-hidden-columns');
             } else {
              $("#crudTable").removeClass('has-hidden-columns');
             }
        } );
      @else
        // make sure the column headings have the same width as the actual columns
        // after the user manually resizes the window
        var resizeTimer;
        function resizeCrudTableColumnWidths() {
          clearTimeout(resizeTimer);
          resizeTimer = setTimeout(function() {
            // Run code here, resizing has "stopped"
            crud.table.columns.adjust();
          }, 250);
        }
        $(window).on('resize', function(e) {
          resizeCrudTableColumnWidths();
        });
        $(document).on('expanded.pushMenu', function(e) {
          resizeCrudTableColumnWidths();
        });
        $(document).on('collapsed.pushMenu', function(e) {
          resizeCrudTableColumnWidths();
        });
      @endif

    });
  </script>

  @include('crud::inc.details_row_logic')
