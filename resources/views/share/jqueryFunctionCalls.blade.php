@if($loadScript == 1)
<script>
    $(document).ready( function(){

        //FUNCTION TO GET LIST OF COLLECTION VIA CATEGORY
        var categoryID = $('#getCategory').val();
        if(categoryID != '')
        {
            getProductCollectionList(categoryID);
        }
        function getProductCollectionList(categoryID)
        {
            if (categoryID != "")
            {
                $.ajax({
                    //url: '{{(Route::has("getAllCollection_ajax_call") ? Route("getAllCollection_ajax_call", ["categoryID" =>' . categoryID .']) : "#" )}}',
                    url: '{{url("/product-collection/")}}' + '/' + categoryID,
                    type: 'get',
                    //data: {'classID': classID, '_token': $('input[name=_token]').val()},
                    data: { format: 'json' },
                    dataType: 'json',
                    success: function(data) {
                        $('#getCollection').empty();
                        $('#getCollection').append($('<option>').text(" Select collection ").attr('value',""));
                        @if((isset($editRecord) && $editRecord && $editRecord->collectionID))
                            $('#getCollection').append($('<option selected>').text("{{$editRecord->collection}}").attr('value', {{$editRecord->collectionID}} ));
                        @endif
                        $.each(data, function(model, list) {
                            $('#getCollection').append($('<option>').text(list.collection).attr('value', list.collectionID));
                        });
                    },
                    error: function(error) {
                        alert("Please we are having issue getting your collection list. Check your network/refresh this page !");
                    }
                });
            }else{
                $('#getCollection').empty();
                $('#getCollection').append($('<option>').text(" No collection found ").attr('value',""));
            }//end if
        };//end function
        //calling a function to GET LIST OF COLLECTION
        $('#getCategory').change(function() {
            var categoryID = $('#getCategory').val();
            if (categoryID == "")
            {
                alert('Please select a category from the list!');
                return false;
            }
            getProductCollectionList(categoryID);
        });
        //END COLLECTION




        //FUNCTION TO UPDATE SHOP CART
        $('.flagMessage').click(function() {
            var messageID = this.id;
            if(messageID != "")
            {
                $.ajax({
                    url: '{{url("/flag-message/")}}' + '/' + messageID,
                    type: 'get',
                    data: { format: 'json' },
                    dataType: 'json',
                    success: function(data)
                    {},
                    error: function(error) {
                       //alert('Sorry, we cannot update your message!');
                        return;
                    }
                });
            }else{}//end if
            //$(".modalMessage" + messageID).modal('show');
        });


        //FUNCTION TO SEND ORDER NUMBER TO AGENT
        $('.hireAgent').click(function() {
            var auid    = this.id;
            var on      = $('#deliveryOrderNumber' + auid).val();
            var m       = $('#message' + auid).val();
            if(on == '')
            {
                $('#feedBack' + auid).html('Sorry, you have not entered your order number!').css('color', 'red');
                return;
            }
            if(auid != "")
            {
                $.ajax({
                    url: '{{url("/send-order-number-to-agent/")}}' +'/'+ auid +'/'+ on +'/'+ m,
                    type: 'get',
                    data: { format: 'json' },
                    dataType: 'json',
                    success: function(data)
                    {
                        if(data == 2)
                        {
                            $('#feedBack' + auid).html('Sorry, this order number has a closed delivery').css('color', 'blue');
                        }else if(data == 1){
                            $('#feedBack' + auid).html('Your order number had been sent to the agent. Contact him/her to expedite your delivery. Thanks').css('color', 'green');
                            $('#deliveryOrderNumber' + auid).val('');
                            $('#message' + auid).val('');
                        }else{
                            $('#feedBack' + auid).html('We are unable to send your order number to the agent! It seems your order number is invalid.').css('color', 'red');
                        }

                    },
                    error: function(error) {
                       alert('Sorry, we cannot send your order number now! Please refresh this page and try again.');
                        return;
                    }
                });
            }else{
                $('#feedBack' + auid).html('Sorry, we cannot submit your information now. Try again.').css('color', 'red');
            }//end if
        });


        //FUNCTION TO SEND ORDER NUMBER TO AGENT
        $('.rejectAcceptBtn').click(function() {
            var aoID    = this.id;
            var agentAction = $('#rejectAccept' + aoID).val();
            if(aoID == '')
            {
                $('#feedBack' + aoID).html('Sorry, we cannot process your action. Refresh this page and try again!').css('color', 'red');
                return;
            }
            if(aoID != "")
            {
                $.ajax({
                    url: '{{url("/agent-confirm-user-order/")}}' +'/'+ aoID +'/'+ agentAction,
                    type: 'get',
                    data: { format: 'json' },
                    dataType: 'json',
                    success: function(data)
                    {
                        if(data)
                        {
                            $('#feedBack' + aoID).html('Accepted! You have successfully accepted this user order. Expedite delivery. User will be notified. Thanks').css('color', 'green');
                           //refresh
                           location.reload(true);
                        }else{
                            $('#feedBack' + aoID).html('Rejected! You have successfully rejected this order. User will be notified. This order has been removed. Thanks').css('color', 'red');
                            //refresh
                            location.reload(true);
                        }
                    },
                    error: function(error) {
                        alert('Sorry, we cannot process your action. Refresh this page and try again!');
                        return;
                    }
                });
            }else{
                $('#feedBack' + aoID).html('Sorry, we cannot submit your action now. Please try again.').css('color', 'blue');
            }//end if
        });




    });
</script>
@endif
