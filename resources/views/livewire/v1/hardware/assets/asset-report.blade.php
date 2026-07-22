<style>
    .user-card {
        /* background: linear-gradient(135deg, #407bd449 0%, #ffffff 50%); */
        background-color: #88ade48b;
        border-radius: 20px;
        border: none;
        overflow: hidden;
        position: relative;
    }
</style>
<div class="container-fluid p-5">
    <div class="row">
        <div class="col-md-2">
            <img src="{{ asset('asset/images/logo.png') }}" alt="" srcset="" style="width: 200px;">
        </div>
        <div class="col-md-10">
            <h1 class="text-center">{{ __('IT Asset Receipt') }}</h1>
            {{-- <p class="text-center">{{ __('IT Department') }}</p> --}}
        </div>
    </div>
    <h3 class="mb-3">{{ __('Date') }} : {{ now()->format('Y - m - d') }}</h3>

    <div class="row">
        <div class="user-card  p-5 mb-4 shadow-sm">
            <div class="d-flex align-items-center justify-content-between ">
                <div style="position: relative; z-index: 1;">

                    <h5 class="text-dark  mb-2">
                        Date : {{ now()->format('d / m / Y') }}
                    </h5>
                    <h4 class="text-dark fw-bold mb-2">
                        Name : {{ $asset->assignments[0]['user']['name'] }}
                    </h4>
                    <h4 class="text-dark fw-bold mb-2">
                        Department : {{ $asset->assignments[0]['user']['category']['name'] }}
                    </h4>
                    <h5 class="text-dark fw-bold mb-2">
                        Title : {{ $asset->assignments[0]['user']['title'] }}
                    </h5>
                </div>
                <div class="d-none d-md-block text-dark" style="position: relative; z-index: 1;" dir="rtl">

                    <h5 class="text-dark  mb-2">
                        التاريخ : {{ now()->format('d / m / Y') }}
                    </h5>
                    <h5 class="text-dark fw-bold mb-3">
                        الاسم : _________________________
                    </h5>
                    <h5 class="text-dark fw-bold mb-3">
                        الإدارة التابع لها : ___________________
                    </h5>
                    <h5 class="text-dark fw-bold mb-3">
                        الوظيفة : _________________________
                    </h5>
                </div>
            </div>
        </div>
    </div>
    {{-- Employee Info --}}

    <div class="row">
        <h4 class="mb-3" style="text-decoration: underline;" dir="rtl"><b>مواصفات الجهاز كالتالي : </b></h4>

        <table class="table table-bordered table-sm table-responsive text-center  shadow p-3 rounded mb-3"
            style="border:solid 1px">
            <thead class="thead-light">
                <tr class="text-center">
                    <th class="bg-dark text-white">{{ __('Device Model') }}</th>
                    <th class="bg-dark text-white">{{ __('Serial Number') }}</th>
                    @foreach ($asset->specs as $spec)
                        <th class="bg-dark text-white">{{ __($spec->attribute->name) }}</th>
                    @endforeach

                </tr>
            </thead>
            <tbody>
                <tr style=" align-items: center">
                    <td>
                        <h5 class="fw-bold">{{ $asset->brand->name . '  - ' . $asset->typeModel->name }}</h5>
                    </td>
                    <td>
                        <h5 class="fw-bold">{{ $asset->serial_number }}</h5>
                    </td>
                    @foreach ($asset->specs as $spec)
                        <td>
                            <h5 class="fw-bold">{{ $spec->value }}</h5>
                        </td>
                    @endforeach

                </tr>

            </tbody>
        </table>
    </div>
    {{-- Device Info --}}

    <div class="row">
        <div class="col-md-6">
            <h4 class="mb-3 text-start" dir="ltr" style="text-decoration: underline;"><b>The Device Accessories
                    :</b>
            </h4>

            <div class="row text-start">
                <div class="col-md-12">
                    <h5>1. <span></span></h5>
                    <h5>2. <span></span></h5>
                </div>
            </div>

            <h5>I hereby acknowledge that I have received the following device.</h5><br>

            <h5>
                I agree to keep the computer in working condition, and to notify IT department in any way or should the
                computer be lost or stolen. Further, I agree to return this computer at the end of my employment.
            </h5><br><br>

            <div class="row text-center mt-3">
                <div class="col-md-6 ">
                    <h5 dir="">Employee Name <br>________________</h5>
                    <h5 dir="">Employee Signature <br>________________</h5>
                </div>
                <div class="col-md-6">
                    <h5 dir="">IT Name <br>________________</h5>
                    <h5 dir="">IT Signature <br>________________</h5>
                </div>
            </div>
        </div>
        <div class="col-md-6 text-end" style="border-left: 2px solid black">
            <h4 class="mb-3 text-end" dir="rtl" style="text-decoration: underline;"><b>ملحقات الجهاز كالتالي :
                </b>
            </h4>

            <div class="row text-end">
                <div class="col-md-12">
                    <h5>1. <span></span></h5>
                    <h5>2. <span></span></h5>
                </div>
            </div>
            <h6 class="mb-3" dir="rtl">أقر أنا/ __________________ </h6>
            <h6 dir="rtl"> الموظف في إدارة __________________ </h6>
            <h6 dir="rtl">
                <br> <br>
                لدى شركة فاوندرز للتسويق العقاري ش.م.م<br>
                باستلامي جهاز اللاب توب مع ملحقاته والموضحة بياناته أعلاه.
                وألتزم بالمحافظة عليه واستخدامه لأغراض العمل فقط.
                كما أتحمل المسئولية الكاملة في حالة سرقته أو ضياعه أو تلفه.
                كما ألتزم بتسليم الجهاز اللاب توب حين الطلب من إدارة الشركة.
            </h6><br>
            <div class="row text-center mt-3" dir="rtl">
                <div class="col-md-6 ">
                    <h5 dir="">أسم المستلم <br>________________</h5>
                    <h5 dir="">التوقيع <Br>________________</h5>
                </div>
                <div class="col-md-6">
                    <h5 dir="">القائم بدور التسليم <br>{{ Auth::user()->name }}</h5>
                    <h5 dir="">التوقيع <Br>________________</h5>
                </div>
            </div>
            <h6 class="mt-5" dir="rtl">لقد تم تحرير هذا المحضر باللغتين الإنجليزية والعربية،وفى حالة الاختلاف
                يكون الاحتكام في
                ذلك إلى النص العربي.</h6>
        </div>
    </div>
    {{-- Legal Agreement --}}
</div>
