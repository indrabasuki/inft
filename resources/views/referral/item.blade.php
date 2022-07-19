@forelse($data as $item)
    <tr>
        <td>{{ $loop->iteration }} </td>
        <td>{{ Str::upper($item->referral_code) }}</td>
        <td>{{ Str::upper($item->referral_description) }}</td>
        <td>{{ Str::upper($item->type_name) }}</td>
        <td>{{ Str::upper($item->name) }}</td>
        <td>{{ Str::upper($item->created_at) }}</td>
        <td class="text-right">
            <a href="javascript:void(0)" class="edit btn btn-sm border border-dark rounded-pill"
                data-id="{{ $item->id }}"><i class="fas fa-pencil-alt"></i></a>
            <a href="javascript:void(0)" class="delete btn btn-sm border border-dark rounded-pill"
                data-id="{{ $item->id }}">
                <i class="fas fa-trash rounded-circle"></i>
            </a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" align="center">
            <h4>No data</h4>
        </td>
    </tr>
@endforelse
