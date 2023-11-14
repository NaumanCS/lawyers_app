@extends('layouts.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="row">
                <div class="col-md-12 d-flex">

                    <!-- Payments -->
                    <div class="card card-table flex-fill">
                        <div class="card-header">
                            <h4 class="card-title">All Users</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-center">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Role</th>
                                            <th>Category</th>
                                            <th>City</th>
                                            <th>Rating</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allUsers as $users)
                                            <tr>
                                                <td>{{ $users->name }}</td>
                                                <td>{{ $users->email }}</td>
                                                <td>{{ $users->phone }}</td>
                                                <td>{{ $users->role }}</td>
                                               
                                                    <td>
                                                        @foreach ($users->lawyerCategory as $category)
                                                            {{ $category->category->title ?? '' }}
                                                            @if (!$loop->last)
                                                                ,
                                                                <!-- Add a comma after each category except the last one -->
                                                            @endif
                                                        @endforeach
                                                    </td>
                                             

                                                <td>{{ $users->city }}</td>
                                                <td>
                                                    @if ($users->lawyerTotalRating->count('rating') > 0)
                                                    @php
                                                        $averageRating = $users->lawyerTotalRating->sum('rating') / $users->lawyerTotalRating->count('rating');
                                                        $roundedRating = round($averageRating); // Round to the nearest whole number
                                                    @endphp
                                                
                                                    <div class="rating">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= $roundedRating)
                                                                <i class="fas fa-star text-info"></i>
                                                            @else
                                                                <i class="far fa-star"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                
                                                    @if ($averageRating > 2)
                                                        <span class="badge bg-success">Top Lawyer</span>
                                                    @endif
                                                @else
                                                    <!-- Handle the case when there are no ratings -->
                                                @endif
                                                
                                                
                                                
                                              
                                                 
                                                   
                                                </td>


                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Payments -->
                </div>
            </div>
        </div>
    </div>
@endsection
