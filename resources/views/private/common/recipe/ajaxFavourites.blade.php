<script>
    $('.favDelBtn').click(function (e) {
        e.preventDefault();

        if(confirm('Are you sure to delete?')) {
            var url = $(this).attr('href');
            $.get(url,null,function (data,status) {
                $('#favDiv').html(data);
            });
        }else{
            return false;
        }
    });
</script>

<table class="table table-responsive table-bordered">
    <tr>
        <th width="5%">Image</th>
        <th>Label</th>
        <th width="15%">Total Ingredients</th>
        <th width="15%">Calories</th>
        <th width="5%">Action</th>
    </tr>

    @if(count($favourites))
        @foreach($favourites as $favourite)
            <tr>
                <td><img src="{{ $favourite->image }}" alt="Image" class="img-responsive"
                         style="height: 45px; width: 45px"></td>
                <td>{{ $favourite->name }}</td>
                <td>{{ $favourite->no_of_ingredients }}</td>
                <td>{{ $favourite->calories }}</td>
                <td>
                    <a href="{{ url('delete-favourite/'.$favourite->id) }}"
                       class="btn btn-danger btn-xs favDelBtn" type="button"
                       style="color: white"><i class="fa fa-minus-circle"></i> Delete</a>
                </td>
            </tr>
        @endforeach
    @endif
</table>