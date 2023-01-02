<script>
                $(function() {
                    $("#datepickerx").datepicker();
                    $("#datepickerx").datepicker( "option", "dateFormat", "dd\/mm\/yy" );
                    $('tbody').click(function() {
                            alert();

                    });
                });
            </script>
            <p>Date: <input type="text" id="datepickerx"></p>