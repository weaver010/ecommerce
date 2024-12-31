<html>
<body>
	<table style="width: 700px;">
		<tr><td>&nbsp;</td></tr>
		<tr><td><img src="{{ asset('front/images/logo/logo-1.png') }}"></td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>Hello {{$name}},</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>Your order #{{ $order_id }} status has been updated to {{ $order_status }}.</td></tr>
		@if(!empty($courier_name) && !empty($tracking_number))
		<tr><td>&nbsp;</td></tr>
		<tr><td>Courier Name is {{ $courier_name }} and Tracking Number is {{ $tracking_number }}</td></tr>
		@endif
		<tr><td>&nbsp;</td></tr>
		<tr><td>Your order details are as below :-</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>
			<table style="width: 95%" cellpadding="5" cellspacing="5" bgcolor="#f7f4f4">
				<tr bgcolor="#cccccc">
					<td>Product Name</td>
					<td>Code</td>
					<td>Size</td>
					<td>Color</td>
					<td>Quantity</td>
					<td>Price</td>
				</tr>
				@foreach($orderDetails['orders_products'] as $order)
				<tr>
					<td>{{ $order['product_name'] }}</td>
					<td>{{ $order['product_code'] }}</td>
					<td>{{ $order['product_size'] }}</td>
					<td>{{ $order['product_color'] }}</td>
					<td>{{ $order['product_qty'] }}</td>
					<td>INR {{ $order['product_price'] }}</td>
				</tr>
				@endforeach
				<tr>
					<td colspan="5" align="right">Shipping Charges</td>
					<td>INR {{ $orderDetails['shipping_charges'] }}</td>
				</tr>
				<tr>
					<td colspan="5" align="right">Coupon Discount</td>
					<td>INR 
						@if($orderDetails['coupon_amount']>0)
							{{ $orderDetails['coupon_amount'] }}
						@else
							0
						@endif
					</td>
				</tr>
				<tr>
					<td colspan="5" align="right">Grand Total</td>
					<td>INR {{ $orderDetails['grand_total'] }}</td>
				</tr>
			</table>
		</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>
			<table>
				<tr>
					<td><strong>Delivery Address :-</strong></td>
				</tr>
				<tr>
					<td>{{ $orderDetails['name'] }}</td>
				</tr>
				<tr>
					<td>{{ $orderDetails['address'] }}</td>
				</tr>
				<tr>
					<td>{{ $orderDetails['city'] }}</td>
				</tr>
				<tr>
					<td>{{ $orderDetails['state'] }}</td>
				</tr>
				<tr>
					<td>{{ $orderDetails['country'] }}</td>
				</tr>
				<tr>
					<td>{{ $orderDetails['pincode'] }}</td>
				</tr>
				<tr>
					<td>{{ $orderDetails['mobile'] }}</td>
				</tr>
			</table>
		</td></tr>
		@if(!empty($courier_name) && !empty($tracking_number))
		<tr><td>&nbsp;</td></tr>
		<tr><td>Download Order Invoice at <a href="{{ url('orders/invoice/download/'.$orderDetails['_id'].'') }}">{{ url('orders/invoice/download/'.$orderDetails['_id'].'') }}</a><br>(Copy & Paste to open if link does not work)</a></td></tr>
		@endif
		<tr><td>&nbsp;</td></tr>
		<tr><td>For any enquiries, you can contact us at <a href="info@stackdevelopers.in">info@stackdevelopers.in</a></td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>Regards,<br>Team Stack Developers</td></tr>
		<tr><td>&nbsp;</td></tr>
	</table>
</body>
</html>  