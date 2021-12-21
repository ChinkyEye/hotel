<p>Item Menu</p>
<table>
  <thead class="table-primary">                  
    <tr>
      <th>SN</th>
      <th>Item</th>
      <th>Quantity</th>
      <th>Unit</th>
      <th>Price</th>
      <th>Category</th>
      <th>Type</th>
      <th>Issued Date (Np/En)</th>
    </tr>
  </thead>
  <tbody>
      @foreach($items as $index=>$order)
    <tr>
      <td>{{$index+1}}</td>
      <td>{{$order->name}}</td>
      <td>{{$order->quantity}}</td>
      <td>{{$order->unit->name}}</td>
      <td>{{$order->price}}</td>
      <td>{{$order->category->name}}</td>
      @if($order->item_type_id == '1')
      <td>
        Ready Made
      </td>
      @else
      <td>Kitchen</td>
      @endif
      <td>{{$order->created_at_np}}/{{$order->created_at}}</td>
    </tr>
      @endforeach
  </tbody>
</table>