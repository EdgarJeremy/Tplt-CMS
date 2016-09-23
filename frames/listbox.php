
						<ul id="boxes">
							<li class="box red">
								<h2><i class="fa fa-newspaper-o fa-lg"></i>&nbsp;Berita</h2>
								<span class="num"><h3><?php echo $berita->hitungJumlah();?></h3><span>Publikasi Baru</span></span>
								<a href="daftarberita" class="bottom-info">
									Lihat semua berita
									<span class="fa fa-arrow-circle-o-right fa-sm"></span>
								</a>
							</li>
							<li class="box blue">
								<h2><i class="fa fa-picture-o fa-lg"></i>&nbsp;Gallery</h2>
								<span class="num"><h3><?php echo $gallery->hitungJumlah();?></h3><span>Upload Baru</span></span>
								<a href="daftarfoto" class="bottom-info">
									Lihat semua gallery
									<span class="fa fa-arrow-circle-o-right fa-sm"></span>
								</a>
							</li>
							<li class="box green">
								<h2><i class="fa fa-book fa-lg"></i>&nbsp;Agenda</h2>
								<span class="num"><h3><?php echo $agenda->hitungJumlah();?></h3><span>Jadwal Berjalan</span></span>
								<a href="daftaragenda" class="bottom-info">
									Lihat semua agenda
									<span class="fa fa-arrow-circle-o-right fa-sm"></span>
								</a>
							</li>
							<li class="box yellow">
								<h2><i class="fa fa-eye fa-lg"></i>&nbsp;Pengunjung</h2>
								<span class="num"><h3><?php echo $pengunjung->hitungJumlah();?></h3><span>Kunjungan Berlangsung</span></span>
								<a href="javascript:void(0)" id="scrollKeChart" class="bottom-info">
									Statistik pengunjung
									<span class="fa fa-arrow-circle-o-down fa-sm"></span>
								</a>
							</li>
						</ul>
