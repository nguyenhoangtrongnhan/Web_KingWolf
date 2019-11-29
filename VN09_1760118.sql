--cau 1:
--docgia I(+) D(-) U(-)
--phieumuon I(-) D(+) U(+)(mapm)

if OBJECT_ID('UTR1','TR') is not null
	drop trigger UTR1
go
create trigger UTR1
on PhieuMuon
for DELETE
as
begin
	if not exists (select *from deleted d where d.madg not in (select madg from PhieuMuon))
	insert PhieuMuon 
	select *from deleted d where d.madg not in (select madg from PhieuMuon)
end

--cau 2:
--Phieumuon I(+) D(-) U(-)
--CT_phieumuon I(-) D(+) U(+) (isbn)
select *from CT_PhieuMuon
if OBJECT_ID('UTR2','TR') is not null
	drop trigger UTR2
go
create trigger UTR2
on CT_PhieuMuon
for DELETE	
as
begin
	if not exists (select *from deleted d where d.mapm in (select mapm from PhieuMuon))
	insert CT_PhieuMuon
	select *from deleted d where d.mapm in (select mapm from PhieuMuon)
end

--cau 3:
--phieutra I(+) D(-) U(+)(ngaytra)
if OBJECT_ID('UTR3','TR') is not null
	drop trigger UTR3
go
create trigger UTR3
on PhieuTra
for insert,update
as
begin
	insert into PhieuTra
	 select d.ngaytra from inserted d where d.ngaytra > (select ngaymuon from PhieuMuon pm where pm.mapm=d.mapm)
				
	delete from PhieuTra
	from inserted d where d.ngaytra < (select ngaymuon from PhieuMuon pm where pm.mapm=d.mapm)
end

--doc gia I(+) D(-) U(+) (CMND)
if OBJECT_ID('UTR4','TR') is not null
	drop trigger UTR4
go
create trigger UTR4
on Docgia
for insert,update
as
begin
	insert into DocGia
	select d.socmnd from inserted d where d.socmnd not in (select socmnd from DocGia dg where d.madg= dg.madg)
				
	delete from DocGia
	 from inserted d where d.socmnd in (select socmnd from DocGia dg where d.madg= dg.madg)
end

--cau 5:
--Docgia I(+) D(-) U(+) (email)
if OBJECT_ID('UTR5','TR') is not null
	drop trigger UTR5
go
create trigger UTR5
on Docgia
for update
as if UPDATE(email) 
begin
	update DocGia 
	set email=i.email 
	from inserted i, DocGia dg where i.madg=dg.madg and i.email like N'%@%'

	delete DocGia from inserted i, DocGia dg where i.madg=dg.madg and i.email not like N'%@%'
	
end
go

--cau 6:
--cuon sach I(-) D(+) U(-) (Tinhtrang)
--CT_phieutra I(+) D(-) U(+)
if OBJECT_ID('UTR6','TR') is not null
	drop trigger UTR6
go
create trigger UTR6 on  CT_PhieuTra
for update
as 
begin
	if  exists (select mapt from inserted i,CuonSach cs where i.isbn=cs.isbn)
	begin
		update CuonSach
		set tinhtrang = N'Chua duoc tra' from CuonSach cs, inserted i where cs.isbn=i.isbn 
	end
end
go

--cau 7:
--cuon sach I(-) D(-) U(-) (Tinhtrang)
--CT_phieutra I(+) D(-) U(+)
if OBJECT_ID('UTR7','TR') is not null
	drop trigger UTR7
go
create trigger UTR7 on CT_PhieuTra
for update,insert
as 
begin
	if not exists (select mapt from inserted i,CuonSach cs where i.isbn=cs.isbn )
	begin
		update CuonSach
		set tinhtrang = N'co the muon' from CuonSach cs, inserted i where cs.isbn=i.isbn 
	end
end
go

--cau 8:
--ct_phieumuon I(-) D() U(+) (songayquydinh)
--phieumuon I(-) D() U(+) (ngaymuon)
--phieutra I(-) D() U(+) (ngaytra)
--CT_phieutra I(+) D() U(+) (mucphat)
if OBJECT_ID('UTR8','TR') is not null
	drop trigger UTR8
go
create trigger UTR8
on CT_PhieuTra
for insert
as 
begin
	declare @ngaymuon date,@ngaytra date, @songayqd int,@tienphat int
	set @ngaymuon=(select ngaymuon from PhieuMuon pm,PhieuTra pt where pt.mapm=pm.mapm)
	set @ngaytra =(select ngaytra from PhieuMuon pm,PhieuTra pt where pt.mapm=pm.mapm)
	set @songayqd=(select songayquydinh from CT_PhieuMuon ctp,PhieuMuon pm where ctp.mapm=pm.mapm)
	set @tienphat=(datediff(day,@ngaytra,@ngaymuon)-@songayqd)* (select mucgiaphat from CT_PhieuTra)
	insert into CT_PhieuTra select *from inserted where @tienphat >0    
end
go

--cau 9:
--phieu muon I(-) D(+) U(-)
if OBJECT_ID('UTR9a','TR') is not null
	drop trigger UTR9a
go
create trigger UTR9a on PhieuMuon
for Delete
as 
begin
	if exists (select d.mapm from deleted d, PhieuTra pt where d.mapm=pt.mapm)
		insert PhieuMuon  select * from deleted d, PhieuTra pt where d.mapm=pt.mapm
end
go

--cau 10:
--phieutra I(+) D(-) U(-)
--CT_phieutra I() D(+) U(+) (mapm)
if OBJECT_ID('UTR10b','TR') is not null
	drop trigger UTR10b
go
create trigger UTR10b
on CT_PhieuTra
for Delete
as
begin
	declare @count int
	set @count=(select count(*) from CT_PhieuTra ct,PhieuTra pt where ct.mapt=pt.mapt)
	if(@count<1)
	insert CT_PhieuTra select *from deleted d,PhieuTra pt where  d.mapt=pt.mapt
end
go

