var SymmetricsCashTicket = Class.create();
// Create a new prototype class
SymmetricsCashTicket.prototype = {
    initialize: function(name) {
		this.name = name;
		// Get base url from blank_img path
        this.baseUrl = BLANK_IMG.substr (0, BLANK_IMG.length-13);
        // Define action url
        this.actionUrl = 'index.php/cashticket/adminhtml_cashticket/default/';
    },
    // Post an ajax request with selected values
    doCashTicketAction: function(action) {
    	var url = this.baseUrl + this.actionUrl;
    	var postData = {
    		// Value from selectbox - modify or debit
    		'cashticketAction': $F('cashticket_action'),
    		// Amount to be modified or debited
	        'amount': $('cashticket_amount').getValue(),
	        // Current order ID
	        'orderId': $('cashticket_order_id').getValue(),
	        // Current transaction ID
	        'transactionId': $('cashticket_transaction_id').getValue(),
	        // Total disposition value
	        'totalDispo': $('cashticket_disposition_total').getValue()
    	};
    	// Post the request and reload the page on success
        new Ajax.Request(url, {
	        	method: 'post',
	            parameters: postData,
	            onSuccess: function() {
	    			window.location.reload()
	        	}
	        }
        );
    }
}

var symmetrics_cashticket = new SymmetricsCashTicket();