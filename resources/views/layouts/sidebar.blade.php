<!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">
				<ul class="metismenu" id="menu">
                    @if (Auth::guard('admin')->user()->level == 'Admin')
                    <li><a href="{{ route('admin')}}" class="ai-icon {{ request()->routeIs('admin') ? 'mm-active' : '' }}" aria-expanded="false">
                            <i class="flaticon-381-home-2"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('adminAb.index')}}" class="{{ request()->routeIs('adminAb.*') ? 'mm-active' : '' }}" class="ai-icon " aria-expanded="false">
                            <i class="flaticon-381-user"></i>
                            <span class="nav-text">Checkin</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('barang.*','satuan.*') ? 'mm-active' : '' }}">
                        <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-381-file"></i>
							<span class="nav-text">Master</span>
						</a>
                        <ul aria-expanded="false">
                            <li>
                                <a href="{{ route('barang.index')}}" class="{{ request()->routeIs('barang.index') ? 'mm-active' : '' }}" aria-expanded="false">
                                    -&nbsp;Barang</a>
                            </li>
                            <li>
                                <a href="{{ route('satuan.index')}}" class="{{ request()->routeIs('satuan.index') ? 'mm-active' : '' }}" aria-expanded="false">
                                    -&nbsp;Satuan
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('tujuan.index')}}" class="{{ request()->routeIs('tujuan.index') ? 'mm-active' : '' }}" aria-expanded="false">
                                    -&nbsp;Tujuan
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="{{ route('operator.index')}}" class="ai-icon {{ request()->routeIs('operator.*') ? 'mm-active' : '' }}" aria-expanded="false">
                            <i class="flaticon-381-user"></i>
                            <span class="nav-text">Operator</span>
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('member.*','kendaraan.*') ? 'mm-active' : '' }}">
                        <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-381-user"></i>
							<span class="nav-text">Member</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('tampil.member')}}" class="{{ request()->routeIs('tampil.member') ? 'mm-active' : '' }}" aria-expanded="false">-&nbsp;Member</a></li>
                            <li><a href="{{ route('member.index')}}" class="{{ request()->routeIs('member.index') ? 'mm-active' : '' }}" aria-expanded="false">-&nbsp;Pengajuan</a></li>
                            <li><a href="{{ route('kendaraan.index')}}" class="{{ request()->routeIs('kendaraan.index') ? 'mm-active' : '' }}" aria-expanded="false">-&nbsp;Kendaraan</a></li>
                        </ul>
                    </li>
                    <li class="{{ request()->routeIs('transaksi.hari') ? 'mm-active' : '' }}">
                        <a class="has-arrow ai-icon" href="#" aria-expanded="false">
                            <i class="flaticon-381-newspaper"></i>
                            <span class="nav-text">Laporan</span>
                        </a>
                        <ul aria-expanded="false">
                            <li>
                                <a href="{{ route('transaksi.hari')}}" class="{{ request()->routeIs('transaksi.hari') ? 'mm-active' : '' }}" aria-expanded="false">
                                    -&nbsp;Hari
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('transaksi.bulan')}}" class="{{ request()->routeIs('transaksi.bulan') ? 'mm-active' : '' }}" aria-expanded="false">
                                    -&nbsp;Bulan
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('transaksi.tahun')}}" class="{{ request()->routeIs('transaksi.tahun') ? 'mm-active' : '' }}" aria-expanded="false">
                                    -&nbsp;Tahun
                                </a>
                            </li>
                        </ul>
                    </li>



                    <li class="{{ request()->routeIs('transaksi.hari') ? 'mm-active' : '' }}">
                        <a class="has-arrow ai-icon" href="#" aria-expanded="false">
                            <i class="flaticon-381-newspaper"></i>
                            <span class="nav-text">File Laporan</span>
                        </a>
                        <ul aria-expanded="false">
                            <li>
                                <a href="{{ route('laporan.perpelanggan')}}" class="{{ request()->routeIs('laporan.perpelanggan') ? 'mm-active' : '' }}" aria-expanded="false">
                                    -&nbsp;Perpelanggan
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('laporan.barang.perpelanggan')}}" class="{{ request()->routeIs('laporan.barang.perpelanggan') ? 'mm-active' : '' }}" aria-expanded="false">
                                    -&nbsp;Barang Perpelanggan
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('laporan.perbarang')}}" class="{{ request()->routeIs('laporan.perpelanggan') ? 'mm-active' : '' }}" aria-expanded="false">
                                    -&nbsp;Perbarang
                                </a>
                            </li>

                        </ul>
                    </li>


                    <li><a href="{{ route('setting.index')}}" class="ai-icon {{ request()->routeIs('setting.*') ? 'mm-active' : '' }}" aria-expanded="false">
                            <i class="flaticon-381-settings-2"></i>
                            <span class="nav-text">Setting</span>
                        </a>
                    </li>
                    @elseif (Auth::guard('admin')->user()->level == 'Operator')
                    <li>
                        <a href="{{ route('home.index')}}" class="ai-icon {{ request()->routeIs('home.*') ? 'mm-active' : '' }}" aria-expanded="false">
                            <i class="flaticon-381-home-2"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('transaksi.index')}}" class="ai-icon {{ request()->routeIs('transaksi.*') ? 'mm-active' : '' }}" aria-expanded="false">
                            <i class="flaticon-381-file"></i>
                            <span class="nav-text">Transaksi</span>
                        </a>
                    </li>
                    @else
                    <li>
                        <a href="{{ route('home.index2')}}" class="ai-icon {{ request()->routeIs('home.*') ? 'mm-active' : '' }}" aria-expanded="false">
                            <i class="flaticon-381-home-2"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('adminAb.index.op2')}}" class="{{ request()->routeIs('adminAb.*') ? 'mm-active' : '' }}" class="ai-icon " aria-expanded="false">
                            <i class="flaticon-381-user"></i>
                            <span class="nav-text">Checkin</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('transaksi.index.op2')}}" class="ai-icon {{ request()->routeIs('transaksi.*') ? 'mm-active' : '' }}" aria-expanded="false">
                            <i class="flaticon-381-file"></i>
                            <span class="nav-text">Transaksi</span>
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="{{ url('logout')}}" class="ai-icon" aria-expanded="false">
                            <i class="flaticon-381-turn-off"></i>
                            <span class="nav-text">Keluar</span>
                        </a>
                    </li>
                </ul>
			</div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->

		<!--**********************************
            EventList
        ***********************************-->

		<div class="event-sidebar dz-scroll" id="eventSidebar">
			<div class="card shadow-none rounded-0 bg-transparent h-auto mb-0">
				<div class="card-body text-center event-calender pb-2">
					<input type='text' class="form-control d-none" id='datetimepicker1' />
				</div>
			</div>
		</div>
