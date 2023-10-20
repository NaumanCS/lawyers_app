@extends('front-layouts.master-lawyer-layout')
@section('injected-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha512-xxxxx" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('front') }}/assets/css/custom.css">
@endsection
@section('content')
    @if (session('message'))
        <div id="flash-message" class="mb-3">
            @include('flash::message')
        </div>
    @endif
    <form action="{{ route('lawyer.profile.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="widget">
            <div class="row">
                <div class="col-xl-6">
                    <h4 class="widget-title">Profile</h4>
                </div>
                <div class="form-group col-xl-6">
                    <div class="media align-items-center mb-3 d-flex">
                        <div class="avatar-upload">
                            <div class="avatar-edit">
                                <input type="file" id="imageUpload" name="image" accept=".png, .jpg, .jpeg" hidden />
                                <label for="imageUpload" class="btn btn-primary" class="pencil-lable"><i
                                        class="fas fa-pencil-alt"></i>
                                </label>
                            </div>
                            <div class="avatar-preview">
                                <div id="imagePreview" style="background-image: url({{ $user->image ?? '' }});"></div>
                            </div>
                        </div>
                        <div class="media-body">
                            <p class="mb-0">Advocate</p>
                            <h5 class="mb-0">{!! $user->name !!}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="personal-info-tab" data-toggle="tab" href="#personal-info" role="tab"
                        aria-controls="personal-info" aria-selected="true">Personal Information</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="documents-tab" data-toggle="tab" href="#documents" role="tab"
                        aria-controls="documents" aria-selected="false">Documents</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="account-setting-tab" data-toggle="tab" href="#account-setting" role="tab"
                        aria-controls="account-setting" aria-selected="false">Account Setting</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="personal-info" role="tabpanel"
                    aria-labelledby="personal-info-tab">
                    <div class="row">
                        <div class="col-xl-12">
                            <h5 class="form-title">Personal Information</h5>
                        </div>
                        <div class="form-group col-xl-6">
                            <label class="me-sm-2 black_label">Name</label>
                            <input class="form-control black_input" name="name" type="text"
                                value="{!! $user->name !!}">
                            @error('name')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-xl-6">
                            <label class="me-sm-2 black_label">Email</label>
                            <input class="form-control black_input" name="email" type="email"
                                value="{!! $user->email !!}">
                            @error('email')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-xl-6">
                            <label class="me-sm-2 black_label">Mobile Number</label>
                            <input class="form-control black_input no_only" name="phone" type="text"
                                value="{!! $user->phone !!}" required>
                            @error('phone')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-xl-6">
                            <label class="me-sm-2 black_label">Date of birth</label>
                            <input type="date" class="form-control black_input white-date-input provider_datepicker"
                                autocomplete="off" onchange="validateBirthdate(event)" name="date_of_birth"
                                value="{!! $user->date_of_birth !!}">
                            <small id="birthdateError" class="form-text text-danger"></small>
                            @error('date')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-xl-6">
                            <label class="me-sm-2 black_label">Gender</label>
                            <select class="form-control form-select black_input" name="gender">
                                <option>Select Gender</option>
                                <option value="male" {{ $user->gender === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ $user->gender === 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ $user->gender === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-xl-12">
                            <h5 class="form-title">Address Information</h5>
                        </div>
                        <div class="form-group col-xl-12">
                            <label class="me-sm-2 black_label">Address</label>
                            <input type="text" name="address" class="form-control black_input"
                                value="{{ $user->address ?? '' }}">
                            @error('address')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-xl-6">
                            <label class="me-sm-2" for="country">Country</label>
                            <select class="form-control form-select black_input" name="country" id="country_id">
                                <option value={{ $user->country ? $user->country : '' }}>
                                    {{ $user->country ? $user->country : 'Select Country' }}</option>
                                <option value='1'>Afghanistan(+93)</option>
                                <option value='2'>Albania(+355)</option>
                                <option value='3'>Algeria (+213)</option>
                                <option value='4'>American Samoa(+684)</option>
                                <option value='5'>Andorra (+376)</option>
                                <option value='6'>Angola (+244)</option>
                                <option value='7'>Anguilla (+1264)</option>
                                <option value='8'>Antarctica(+672)</option>
                                <option value='9'>Antigua & Barbuda (+1268)</option>
                                <option value='10'>Argentina (+54)</option>
                                <option value='11'>Armenia (+374)</option>
                                <option value='12'>Aruba (+297)</option>
                                <option value='13'>Australia (+61)</option>
                                <option value='14'>Austria (+43)</option>
                                <option value='15'>Azerbaijan (+994)</option>
                                <option value='16'>Bahamas (+1242)</option>
                                <option value='17'>Bahrain (+973)</option>
                                <option value='18'>Bangladesh (+880)</option>
                                <option value='19'>Barbados (+1246)</option>
                                <option value='20'>Belarus (+375)</option>
                                <option value='21'>Belgium (+32)</option>
                                <option value='22'>Belize (+501)</option>
                                <option value='23'>Benin (+229)</option>
                                <option value='24'>Bermuda (+1441)</option>
                                <option value='25'>Bhutan (+975)</option>
                                <option value='26'>Bolivia (+591)</option>
                                <option value='27'>Bosnia Herzegovina (+387)</option>
                                <option value='28'>Botswana (+267)</option>
                                <option value='29'>Bouvet Island(+55)</option>
                                <option value='30'>Brazil (+55)</option>
                                <option value='31'>British Indian Ocean Territory(+246)</option>
                                <option value='32'>Brunei (+673)</option>
                                <option value='33'>Bulgaria (+359)</option>
                                <option value='34'>Burkina Faso (+226)</option>
                                <option value='35'>Burundi (+257)</option>
                                <option value='36'>Cambodia (+855)</option>
                                <option value='37'>Cameroon (+237)</option>
                                <option value='38'>Canada (+1)</option>
                                <option value='39'>Cape Verde Islands (+238)</option>
                                <option value='40'>Cayman Islands (+1345)</option>
                                <option value='41'>Central African Republic (+236)</option>
                                <option value='42'>Chad(+235)</option>
                                <option value='43'>Chile (+56)</option>
                                <option value='44'>China (+86)</option>
                                <option value='45'>Christmas Island(+61)</option>
                                <option value='46'>Cocos (Keeling) Islands(+61)</option>
                                <option value='47'>Colombia (+57)</option>
                                <option value='48'>Comoros (+269)</option>
                                <option value='49'>Congo (+242)</option>
                                <option value='50'>Congo The Tom Burnscratic Republic Of The(+243)</option>
                                <option value='51'>Cook Islands (+682)</option>
                                <option value='52'>Costa Rica (+506)</option>
                                <option value='53'>Cote D'Ivoire (Ivory Coast)(+225)</option>
                                <option value='54'>Croatia (+385)</option>
                                <option value='55'>Cuba (+53)</option>
                                <option value='56'>Cyprus North (+90392)</option>
                                <option value='57'>Czech Republic (+42)</option>
                                <option value='58'>Denmark (+45)</option>
                                <option value='59'>Djibouti (+253)</option>
                                <option value='60'>Dominica (+1809)</option>
                                <option value='61'>Dominican Republic (+1809)</option>
                                <option value='62'>East Timor(+670)</option>
                                <option value='63'>Ecuador (+593)</option>
                                <option value='64'>Egypt (+20)</option>
                                <option value='65'>El Salvador (+503)</option>
                                <option value='66'>Equatorial Guinea (+240)</option>
                                <option value='67'>Eritrea (+291)</option>
                                <option value='68'>Estonia (+372)</option>
                                <option value='69'>Ethiopia (+251)</option>
                                <option value='70'>External Territories of Australia(+672)</option>
                                <option value='71'>Falkland Islands (+500)</option>
                                <option value='72'>Faroe Islands (+298)</option>
                                <option value='73'>Fiji (+679)</option>
                                <option value='74'>Finland (+358)</option>
                                <option value='75'>France (+33)</option>
                                <option value='76'>French Guiana (+594)</option>
                                <option value='77'>French Polynesia (+689)</option>
                                <option value='78'>French Southern Territories(262)</option>
                                <option value='79'>Gabon (+241)</option>
                                <option value='80'>Gambia (+220)</option>
                                <option value='81'>Georgia (+7880)</option>
                                <option value='82'>Germany (+49)</option>
                                <option value='83'>Ghana (+233)</option>
                                <option value='84'>Gibraltar (+350)</option>
                                <option value='85'>Greece (+30)</option>
                                <option value='86'>Greenland (+299)</option>
                                <option value='87'>Grenada (+1473)</option>
                                <option value='88'>Guadeloupe (+590)</option>
                                <option value='89'>Guam (+671)</option>
                                <option value='90'>Guatemala (+502)</option>
                                <option value='91'>Guernsey and Alderney(44 1481)</option>
                                <option value='92'>Guinea (+224)</option>
                                <option value='93'>Guinea - Bissau (+245)</option>
                                <option value='94'>Guyana (+592)</option>
                                <option value='95'>Haiti (+509)</option>
                                <option value='96'>Heard and McDonald Islands</option>
                                <option value='97'>Honduras (+504)</option>
                                <option value='98'>Hong Kong (+852)</option>
                                <option value='99'>Hungary (+36)</option>
                                <option value='100'>Iceland (+354)</option>
                                <option value='101'>India (+91)</option>
                                <option value='102'>Indonesia (+62)</option>
                                <option value='103'>Iran (+98)</option>
                                <option value='104'>Iraq (+964)</option>
                                <option value='105'>Ireland (+353)</option>
                                <option value='106'>Israel (+972)</option>
                                <option value='107'>Italy (+39)</option>
                                <option value='108'>Jamaica (+1876)</option>
                                <option value='109'>Japan (+81)</option>
                                <option value='110'>Jersey(+44)</option>
                                <option value='111'>Jordan (+962)</option>
                                <option value='112'>Kazakhstan (+7)</option>
                                <option value='113'>Kenya (+254)</option>
                                <option value='114'>Kiribati (+686)</option>
                                <option value='115'>Korea North (+850)</option>
                                <option value='116'>Korea South (+82)</option>
                                <option value='117'>Kuwait (+965)</option>
                                <option value='118'>Kyrgyzstan (+996)</option>
                                <option value='119'>Laos (+856)</option>
                                <option value='120'>Latvia (+371)</option>
                                <option value='121'>Lebanon (+961)</option>
                                <option value='122'>Lesotho (+266)</option>
                                <option value='123'>Liberia (+231)</option>
                                <option value='124'>Libya (+218)</option>
                                <option value='125'>Liechtenstein (+417)</option>
                                <option value='126'>Lithuania (+370)</option>
                                <option value='127'>Luxembourg (+352)</option>
                                <option value='128'>Macao (+853)</option>
                                <option value='129'>Macedonia (+389)</option>
                                <option value='130'>Madagascar (+261)</option>
                                <option value='131'>Malawi (+265)</option>
                                <option value='132'>Malaysia (+60)</option>
                                <option value='133'>Maldives (+960)</option>
                                <option value='134'>Mali (+223)</option>
                                <option value='135'>Malta (+356)</option>
                                <option value='136'>Man (Isle of)(+44)</option>
                                <option value='137'>Marshall Islands (+692)</option>
                                <option value='138'>Martinique (+596)</option>
                                <option value='139'>Mauritania (+222)</option>
                                <option value='140'>Mauritius(+230)</option>
                                <option value='141'>Mayotte (+269)</option>
                                <option value='142'>Mexico (+52)</option>
                                <option value='143'>Micronesia (+691)</option>
                                <option value='144'>Moldova (+373)</option>
                                <option value='145'>Monaco (+377)</option>
                                <option value='146'>Mongolia (+976)</option>
                                <option value='147'>Montserrat (+1664)</option>
                                <option value='148'>Morocco (+212)</option>
                                <option value='149'>Mozambique (+258)</option>
                                <option value='150'>Myanmar(+95)</option>
                                <option value='151'>Namibia (+264)</option>
                                <option value='152'>Nauru (+674)</option>
                                <option value='153'>Nepal (+977)</option>
                                <option value='154'>Netherlands Antilles(+599)</option>
                                <option value='155'>Netherlands (+31)</option>
                                <option value='156'>New Caledonia (+687)</option>
                                <option value='157'>New Zealand (+64)</option>
                                <option value='158'>Nicaragua (+505)</option>
                                <option value='159'>Niger (+227)</option>
                                <option value='160'>Nigeria (+234)</option>
                                <option value='161'>Niue (+683)</option>
                                <option value='162'>Norfolk Islands (+672)</option>
                                <option value='163'>Northern Mariana Islands(+1)</option>
                                <option value='164'>Norway (+47)</option>
                                <option value='165'>Oman (+968)</option>
                                <option value='166' selected="">Pakistan(+92)</option>
                                <option value='167'>Palau (+680)</option>
                                <option value='168'>Palestinian Territory Occupied(+970)</option>
                                <option value='169'>Panama (+507)</option>
                                <option value='170'>Papua New Guinea (+675)</option>
                                <option value='171'>Paraguay (+595)</option>
                                <option value='172'>Peru (+51)</option>
                                <option value='173'>Philippines (+63)</option>
                                <option value='174'>Pitcairn Island(+64)</option>
                                <option value='175'>Poland (+48)</option>
                                <option value='176'>Portugal (+351)</option>
                                <option value='177'>Puerto Rico (+1787)</option>
                                <option value='178'>Qatar (+974)</option>
                                <option value='179'>Reunion (+262)</option>
                                <option value='180'>Romania (+40)</option>
                                <option value='181'>Russia (+7)</option>
                                <option value='182'>Rwanda (+250)</option>
                                <option value='183'>St. Helena (+290)</option>
                                <option value='184'>St. Kitts (+1869)</option>
                                <option value='185'>Saint Lucia(+1758)</option>
                                <option value='186'>Saint Pierre and Miquelon(+508)</option>
                                <option value='187'>Saint Vincent And The Grenadines(+1784)</option>
                                <option value='188'>Samoa(+685)</option>
                                <option value='189'>San Marino (+378)</option>
                                <option value='190'>Sao Tome & Principe (+239)</option>
                                <option value='191'>Saudi Arabia (+966)</option>
                                <option value='192'>Senegal (+221)</option>
                                <option value='193'>Serbia(+381)</option>
                                <option value='194'>Seychelles (+248)</option>
                                <option value='195'>Sierra Leone (+232)</option>
                                <option value='196'>Singapore (+65)</option>
                                <option value='197'>Slovak Republic (+421)</option>
                                <option value='198'>Slovenia (+386)</option>
                                <option value='199'>Smaller Territories of the UK</option>
                                <option value='200'>Solomon Islands (+677)</option>
                                <option value='201'>Somalia (+252)</option>
                                <option value='202'>South Africa (+27)</option>
                                <option value='203'>South Georgia(+500)</option>
                                <option value='204'>South Sudan(+211)</option>
                                <option value='205'>Spain (+34)</option>
                                <option value='206'>Sri Lanka (+94)</option>
                                <option value='207'>Sudan (+249)</option>
                                <option value='208'>Suriname (+597)</option>
                                <option value='209'>Svalbard And Jan Mayen Islands(+41)</option>
                                <option value='210'>Swaziland (+268)</option>
                                <option value='211'>Sweden (+46)</option>
                                <option value='212'>Switzerland (+41)</option>
                                <option value='213'>Syria(+963)</option>
                                <option value='214'>Taiwan (+886)</option>
                                <option value='215'>Tajikstan (+7)</option>
                                <option value='216'>Tanzania(+255)</option>
                                <option value='217'>Thailand (+66)</option>
                                <option value='218'>Togo (+228)</option>
                                <option value='219'>Tokelau(+690)</option>
                                <option value='220'>Tonga (+676)</option>
                                <option value='221'>Trinidad & Tobago (+1868)</option>
                                <option value='222'>Tunisia (+216)</option>
                                <option value='223'>Turkey (+90)</option>
                                <option value='224'>Turkmenistan (+7)</option>
                                <option value='225'>Turks & Caicos Islands (+1649)</option>
                                <option value='226'>Tuvalu (+688)</option>
                                <option value='227'>Uganda (+256)</option>
                                <option value='228'>Ukraine (+380)</option>
                                <option value='229'>United Arab Emirates (+971)</option>
                                <option value='230'>UK (+44)</option>
                                <option value='231'>USA (+1)</option>
                                <option value='232'>United States Minor Outlying Islands(+246)</option>
                                <option value='233'>Uruguay (+598)</option>
                                <option value='234'>Uzbekistan (+7)</option>
                                <option value='235'>Vanuatu (+678)</option>
                                <option value='236'>Vatican City (+379)</option>
                                <option value='237'>Venezuela (+58)</option>
                                <option value='238'>Vietnam (+84)</option>
                                <option value='239'>Virgin Islands - British (+1284)</option>
                                <option value='240'>Virgin Islands - US (+1340)</option>
                                <option value='241'>Wallis & Futuna (+681)</option>
                                <option value='242'>Western Sahara(+212)</option>
                                <option value='243'>Yemen (North)(+969)</option>
                                <option value='244'>Yugoslavia(+38)</option>
                                <option value='245'>Zambia (+260)</option>
                                <option value='246'>Zimbabwe (+263)</option>
                            </select>
                            @error('country')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-xl-6">
                            <label class="me-sm-2 black_label" for="city">City</label>
                            <input class="form-control black_input" type="text" name="city"
                                value="{!! $user->city !!}">
                            @error('city')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-xl-6">
                            <label class="me-sm-2 black_label" for="state">State</label>
                            <input class="form-control black_input" type="text" name="state"
                                value="{!! $user->state !!}">
                            @error('state')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-xl-6">
                            <label class="me-sm-2 black_label" for="postal_code">Postal Code</label>
                            <input type="text" class="form-control black_input" name="postal_code"
                                value="{{ $user->postal_code ?? '' }}">
                            @error('postal_code')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-xl-12">
                            <button class="btn btn-primary ps-5 pe-5 update_button" type="submit">Update</button>
                        </div>
                    </div>
                </div>
    </form>
    <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="documents-tab">
        <div class="row">
            <div class="col-xl-12">
                <h5 class="form-title">Documents</h5>
            </div>
            <div class="form-group col-xl-6">
                <label class="me-sm-2 black_label">Degree</label>
                <input class="form-control black_input" type="text" value="{!! $user->degree !!}" readonly>

            </div>
            <div class="form-group col-xl-6">
                <label class="me-sm-2 black_label">Qualification</label>
                <input class="form-control black_input" value="{!! $user->qualification !!}" readonly>

            </div>
            <div class="form-group col-xl-12">
                <label class="me-sm-2 black_label">Experience in years</label>
                <input class="form-control black_input no_only" value="{!! $user->experience_in_years !!}" readonly>

            </div>
            <div class="col-xl-4">
                <div class="card">
                    <img src="{{ $user->high_court_licence }}" alt="Certificate 1" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">High Court Licence</h5>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <img src="{{ $user->supreme_court_licence }}" alt="Certificate 2" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Supreme Court Licence</h5>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <img src="{{ $user->qualification_certificate }}" alt="Certificate 3" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Qualification Certificate</h5>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="tab-pane fade" id="account-setting" role="tabpanel" aria-labelledby="account-setting-tab">
        <form action="{{ route('lawyer.account.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="lawyer_id" value="{{ $user->id ?? '' }}">
            <div class="row">
                <div class="col-xl-12">
                    <h5 class="form-title">Bank Account</h5>
                </div>
                <div class="form-group col-xl-6">
                    <label class="me-sm-2 black_label">Bank Account Title</label>
                    <input type="text" class="form-control black_input" name="bank_account_title"
                        value="{{ $user->accountDetail->bank_account_title ?? '' }}">

                </div>
                <div class="form-group col-xl-6">
                    <label class="me-sm-2 black_label">Bank Name</label>
                    <input type="text" class="form-control black_input" name="bank_name"
                        value="{{ $user->accountDetail->bank_name ?? '' }}">

                </div>
                <div class="form-group col-xl-12">
                    <label class="me-sm-2 black_label">Bank Account Number</label>
                    <input type="text" class="form-control black_input" name="bank_account_number"
                        value="{{ $user->accountDetail->bank_account_number ?? '' }}">

                </div>
                <div class="col-xl-12">
                    <h5 class="form-title">JazzCash Account</h5>
                </div>
                <div class="form-group col-xl-12">
                    <label class="me-sm-2 black_label">JazzCash Title</label>
                    <input type="text" class="form-control black_input" name="jazzcash_title"
                        value="{{ $user->accountDetail->jazzcash_title ?? '' }}">

                </div>
                <div class="form-group col-xl-12">
                    <label class="me-sm-2 black_label">JazzCash Number</label>
                    <input type="text" class="form-control black_input" name="jazzcash_number"
                        value="{{ $user->accountDetail->jazzcash_number ?? '' }}">

                </div>
                <div class="form-group col-xl-12">
                    <button class="btn btn-primary ps-5 pe-5 update_button" type="submit">Update</button>
                </div>
            </div>
        </form>
    </div>
    </div>
    </div>
@endsection
@section('injected-scripts')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('.countrypicker').countrypicker();
    </script>
    <script>
        setTimeout(function() {
            document.getElementById('flash-message').style.display = 'none';
        }, 3000);
    </script>
    <script>
        $(document).ready(function() {
            var currentDate = new Date();
            // Format the date as "YYYY-MM-DD"
            var formattedDate = currentDate.toISOString().split('T')[0];
            // Set the max attribute of the birthdate input field
            document.getElementById('provider_datepicker').max = formattedDate;
        });

        function validateBirthdate(event) {
            let date = event.target.value;
            var birthdateError = document.getElementById('birthdateError');

            var currentDate = new Date();
            var selectedDate = new Date(date);

            // Calculate the minimum allowed birthdate (18 years ago)
            var minBirthdate = new Date();
            minBirthdate.setFullYear(currentDate.getFullYear() - 18);

            if (selectedDate > minBirthdate) {
                birthdateError.textContent = 'You must be at least 18 years old.';
                $('.update_button').prop('disabled', true);
            } else {
                birthdateError.textContent = '';
                $('.update_button').prop('disabled', false);
                // Date is valid, continue with further processing or form submission
            }
        }
    </script>
    <script src="{{ asset('front') }}/assets/js/custom.js"></script>
@endsection
