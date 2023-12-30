               </section>
            </section>
        </section>
        <script type="text/javascript" src="/public_html/dashboard/js/datatables/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="/public_html/dashboard/js/bootstrap.js"></script>
        <script type="text/javascript" src="/public_html/dashboard/js/intro/intro.min.js"></script> 
        <script type="text/javascript" src="/public_html/dashboard/js/app.js"></script> 
        <script type="text/javascript" src="/public_html/dashboard/js/slimscroll/jquery.slimscroll.min.js"></script>
        <script type="text/javascript" src="/public_html/dashboard/js/charts/easypiechart/jquery.easy-pie-chart.js"></script>
        <script type="text/javascript" src="/public_html/dashboard/js/charts/sparkline/jquery.sparkline.min.js"></script>
        <script type="text/javascript" src="/public_html/dashboard/js/charts/flot/jquery.flot.min.js"></script>
        <script type="text/javascript" src="/public_html/dashboard/js/charts/flot/jquery.flot.tooltip.min.js"></script>
        <script type="text/javascript" src="/public_html/dashboard/js/charts/flot/jquery.flot.resize.js"></script>
        <script type="text/javascript" src="/public_html/dashboard/js/charts/flot/jquery.flot.grow.js"></script>
        <script type="text/javascript" src="/public_html/dashboard/js/charts/flot/demo.js"></script>
        <script type="text/javascript" src="/public_html/dashboard/js/calendar/bootstrap_calendar.js"></script>
        <script type="text/javascript" src="/public_html/dashboard/js/calendar/demo.js"></script>
        <script type="text/javascript" src="/public_html/dashboard/js/sortable/jquery.sortable.js"></script>
        <script type="text/javascript" src="/public_html/dashboard/js/app.plugin.js"></script>
        <script type="text/javascript" src="/public_html/dashboard/js/file-input/bootstrap-filestyle.min.js"></script>
        <script type="text/javascript" src="/public_html/js/alertify.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/codemirror.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/xml.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/froala_editor.min.js" ></script>
        <script type="text/javascript" src="/public_html/editor/js/plugins/align.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/plugins/char_counter.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/plugins/code_beautifier.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/plugins/code_view.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/plugins/colors.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/plugins/draggable.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/plugins/emoticons.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/plugins/entities.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/plugins/file.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/plugins/font_size.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/plugins/font_family.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/plugins/fullscreen.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/plugins/image.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/plugins/image_manager.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/plugins/line_breaker.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/plugins/inline_style.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/plugins/link.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/plugins/lists.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/plugins/paragraph_format.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/plugins/paragraph_style.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/plugins/quick_insert.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/plugins/quote.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/plugins/table.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/plugins/save.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/plugins/url.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/plugins/video.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/plugins/help.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/plugins/print.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/third_party/spell_checker.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/plugins/special_characters.min.js"></script>
        <script type="text/javascript" src="/public_html/editor/js/plugins/word_paste.min.js"></script>
        
        <script>
            $(document).ready(function(e){
                $(".datepicker").datepicker({
                    clearBtn: true,
                    autoclose: true,
                    format: 'dd/mm/yyyy' 
                });
                
                $(".clockpicker").clockpicker({
                    autoclose: true,
                });
                
                $(".topics").select2({
                    allowClear: true,
                    placeholder: "<?= lang('select_topics'); ?>",
                });
                $(".select2").select2({
                    
                });
                $('.fr-wrapper a[href^="https://www.froala.com/wysiwyg-editor?k=u"]').css('background',"#2e3e4e");
            });
            jQuery.extend(true,$.fn.dataTable.defaults, {
                language : {
                    "sProcessing":    "<?= lang('datatable_sProcessing'); ?>",
                    "sLengthMenu":    "<?= lang('datatable_sLengthMenu'); ?>",
                    "sZeroRecords":   "<?= lang('datatable_sZeroRecords'); ?>",
                    "sEmptyTable":    "<?= lang('datatable_sEmptyTable'); ?>",
                    "sInfo":          "<?= lang('datatable_sInfo'); ?>",
                    "sInfoEmpty":     "<?= lang('datatable_sInfoEmpty'); ?>",
                    "sInfoFiltered":  "<?= lang('datatable_sInfoFiltered'); ?>",
                    "sInfoPostFix":   "<?= lang('datatable_sInfoPostFix'); ?>",
                    "sSearch":       "<?= lang('datatable_sSearch'); ?>",
                    "sInfoThousands":  "<?= lang('datatable_sInfoThousands'); ?>",
                    "sLoadingRecords": "<?= lang('datatable_sLoadingRecords'); ?>",
                    "oPaginate": {
                            "sFirst":    "<?= lang('datatable_sFirst'); ?>",
                            "sLast":    "<?= lang('datatable_sLast'); ?>",
                            "sNext":    "<?= lang('datatable_sNext'); ?>",
                            "sPrevious": "<?= lang('datatable_sPrevious'); ?>"
                            },
                    "oAria": {
                            "sSortAscending":  "<?= lang('datatable_sSortAscending'); ?>",
                            "sSortDescending": "<?= lang('datatable_sSortDescending'); ?>"
                            },
                    sUrl: ""        
                }
            });
            function generate_random_string(length = 10) {
                var result           = '';
                var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                var charactersLength = characters.length;
                for ( var i = 0; i < length; i++ ) {
                   result += characters.charAt(Math.floor(Math.random() * charactersLength));
                }
                return result;
            }
        </script>
    </body>
</html>
