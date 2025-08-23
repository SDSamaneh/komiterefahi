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
                                                                   @if(isset($item->status) && $item->status === 'Yes')
                                                                   <h6 class="badge text-black bg-body-secondary mb-2">مدیر واحد</h6>
                                                                   @endif

                                                                   @if(isset($item->validationHr) && $item->validationHr === 'Yes')
                                                                   <h6 class="badge text-bg-success mb-2">اعتبارسنجی</h6>
                                                                   @endif

                                                                   @if(isset($item->validationManager1) && $item->validationManager1 === 'Yes')
                                                                   <h6 class="badge text-bg-success mb-2">مدیر مالی</h6>
                                                                   @endif

                                                                   @if(isset($item->validationManager2) && $item->validationManager2 === 'Yes')
                                                                   <h6 class="badge text-bg-success mb-2">تایید نهایی</h6>
                                                                   @endif
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
                                                 </tbody>
                                           </table>
                                     </div>
                               </div>
                         </div>
                   </div>
             </div>
       </div>
 </section>