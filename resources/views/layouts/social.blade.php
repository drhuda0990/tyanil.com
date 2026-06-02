<?php
  $institutes_info = DB::table('institutes')
                      ->where('id', '=',1)
                      ->select(
                            'slogan' ,'address','pobox','email_2','mobile','phone' , 'whatsapp' ,'snapchat','telegram',
                            'facebook','tiktok', 'twitter' ,'linkedin','instagram' ,'youtube' , 'page_policy_id' , 'page_bank_accounts_id','place'
                            )
                      ->first();
                      ?>
  
 @if($institutes_info->tiktok)
 <a href="{{ $institutes_info->tiktok }}" target="_blank">
   <img class="contestWidth" src="{{ asset('images/tiktok.png') }}" />
 </a>
 @endif
   @if($institutes_info->linkedin)
 <a href="{{ $institutes_info->linkedin }}"  target="_blank">
   {{-- <i class="icon-facebook"></i> --}}
   <img class="contestWidth" src="{{ asset('images/linked.png') }}" />
 </a>
 @endif
 @if($institutes_info->twitter)
 <a href="{{ $institutes_info->twitter }}"  target="_blank">
   {{-- <i class="icon-twitter"></i> --}}
   <img class="contestWidth" src="{{ asset('images/twitter.png') }}"  />
 </a>
 @endif
 @if($institutes_info->instagram)
 <a href="{{ $institutes_info->instagram }}"  target="_blank">
   {{-- <i class="icon-instagram"></i> --}}
   <img class="contestWidth" src="{{ asset('images/instegram.png') }}"  />
 </a>
 @endif
 @if($institutes_info->youtube)
 <a href="{{ $institutes_info->youtube }}"  target="_blank">
  <img class="contestWidth" src="{{ asset('images/youtube.png') }}" />
   {{-- <i class="icon-youtube"></i> --}}
   
 </a>
 @endif
  @if($institutes_info->snapchat)
     <a href="{{ $institutes_info->snapchat }}"  target="_blank">
      {{-- <i class="fa fa-snapchat"></i> --}}
      <img class="contestWidth" src="{{ asset('images/snap.png') }}" />
     </a>
     @endif
     
       @if($institutes_info->telegram)
     <a href="{{ $institutes_info->telegram }}"  target="_blank">
      {{-- <i class="fa fa-telegram"></i> --}}
      <img class="contestWidth" src="{{ asset('images/telegram.png') }}" />
     </a>
     @endif
      @if($institutes_info->whatsapp)
     <a href="https://api.whatsapp.com/send?phone=+966<?= $institutes_info->whatsapp ?>&text=مرحبا"  target="_blank">
      {{-- <i class="fa fa-whatsapp"></i> --}}
      <img class="contestWidth" src="{{ asset('images/whatsapp.png') }}"  />
     </a>
     @endif
