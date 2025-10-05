 <section class="my-4">
       <div class="container">
             <div class="d-flex justify-content-between align-items-baseline mb-4">
                   <div class="col-12">
                         <div class="card border bg-transparent rounded-3">
                               <div class="card-header bg-transparent border-bottom p-3">
                                     <div class="d-sm-flex justify-content-between align-items-center">
                                           <h5 class="mb-2 mb-sm-0">درخواست های من</h5>
                                     </div>
                               </div>
                               <div class="card-body">
                                     <div class="table-responsive border-0">
                                           <table class="table align-middle p-4 mb-0 table-hover table-shrink">
                                                 <thead class="flex justify-center items-center table-dark">
                                                       <tr>
                                                             <th scope="col" class="border-0 rounded-start">نوع درخواست</th>
                                                             <th scope="col" class="border-0">تاریخ درخواست</th>
                                                             <th scope="col" class="border-0">وضعیت</th>
                                                             <th scope="col" class="border-0">عملیات</th>
                                                       </tr>
                                                 </thead>
                                                 <tbody class="border-top-0">
                                                       @forelse($allRequests as $item)
                                                       <tr>
                                                             <td>{{ $item->type }}</td>
                                                             <td>{{ jdate($item->created_at)->format('Y/m/d') }}</td>
                                                             <td>
                                                                   <ul class="navbar-nav">
                                                                         <li class="nav-item">
                                                                               <i class="fas fa-check-circle" style="color: {{ $item->status == 'Yes' ? 'green' : 'grey' }}"></i> مدیر واحد
                                                                         </li>
                                                                         <li class="nav-item">
                                                                               <i class="fas fa-clock" style="color: {{ $item->validationHr == 'Yes' ? 'green' : 'orange' }}"></i> اعتبار سنجی
                                                                         </li>
                                                                         <li class="nav-item">
                                                                               <i class="fas fa-check-circle" style="color: {{ $item->validation_managerHr == 'Yes' ? 'green' : 'grey' }}"></i> مدیر منابع انسانی
                                                                         </li>
                                                                         <li class="nav-item">
                                                                               <i class="fas fa-check-circle" style="color: {{ $item->validationManager1 == 'Yes' ? 'green' : 'grey' }}"></i> مدیر مالی
                                                                         </li>
                                                                         <li class="nav-item">
                                                                               <i class="fas fa-check-circle" style="color: {{ $item->validationManager2 == 'Yes' ? 'green' : 'grey' }}"></i> رییس کمیته
                                                                         </li>
                                                                   </ul>
                                                             </td>
                                                             <td>
                                                                   @if(!($item->status === 'yes'))
                                                                   <a href="{{ $item->edit_route }}" class="btn btn-light btn-round mb-0" title="ویرایش">
                                                                         <i class="fas fa-edit"></i>
                                                                   </a>
                                                                   @endif
                                                             </td>
                                                       </tr>

                                                       @empty
                                                       <tr>
                                                             <td colspan="5" class="text-center">هیچ درخواستی ثبت نشده است.</td>
                                                       </tr>
                                                       @endforelse

                                                       @forelse($maadirans as $maadiran)
                                                       <tr>
                                                             <td>{{ $maadiran->type }}</td>
                                                             <td>{{ jdate($maadiran->created_at)->format('Y/m/d') }}</td>
                                                             <td>
                                                                   <ul class="navbar-nav">
                                                                         <li class="nav-item">
                                                                               <i class="fas fa-check-circle" style="color: {{ $maadiran->status == 'Yes' ? 'green' : 'grey' }}"></i> مدیر واحد
                                                                         </li>
                                                                         <li class="nav-item">
                                                                               <i class="fas fa-clock" style="color: {{ $maadiran->validationHr == 'Yes' ? 'green' : 'orange' }}"></i> اعتبار سنجی
                                                                         </li>
                                                                         <li class="nav-item">
                                                                               <i class="fas fa-check-circle" style="color: {{ $maadiran->validation_managerHr == 'Yes' ? 'green' : 'grey' }}"></i> مدیر منابع انسانی
                                                                         </li>
                                                                   </ul>
                                                             </td>
                                                             <td>
                                                                   @if(!($maadiran->status === 'yes'))
                                                                   <a href="{{ $maadiran->edit_route }}" class="btn btn-light btn-round mb-0" title="ویرایش">
                                                                         <i class="fas fa-edit"></i>
                                                                   </a>
                                                                   @endif
                                                             </td>
                                                       </tr>

                                                       @empty
                                                       <tr>
                                                             <td colspan="5" class="text-center"></td>
                                                       </tr>
                                                       @endforelse


                                                       @forelse($imprests as $imprest)
                                                       <tr>
                                                             <td>{{ $imprest->type }}</td>
                                                             <td>{{ jdate($imprest->created_at)->format('Y/m/d') }}</td>
                                                             <td>
                                                                   <ul class="navbar-nav">
                                                                         <li class="nav-item">
                                                                               <i class="fas fa-check-circle" style="color: {{ $imprest->accept == 'Yes' ? 'green' : 'grey' }}"></i> مدیر منابع انسانی
                                                                         </li>

                                                                   </ul>
                                                             </td>
                                                             <td>
                                                                   @if(!($imprest->accept === 'yes'))
                                                                   <a href="{{ $imprest->edit_route }}" class="btn btn-light btn-round mb-0" title="ویرایش">
                                                                         <i class="fas fa-edit"></i>
                                                                   </a>
                                                                   @endif
                                                             </td>
                                                       </tr>
                                                       @empty
                                                       <tr>
                                                             <td colspan="5" class="text-center">هیچ درخواست مساعده ثبت نشده است.</td>
                                                       </tr>
                                                       @endforelse

                                                 </tbody>
                                           </table>
                                     </div>
                               </div>
                         </div>
                   </div>
             </div>
       </div>
 </section>