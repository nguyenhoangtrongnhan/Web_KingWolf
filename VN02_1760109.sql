--1.
create proc sp_Tong @a int, @b int, @Sum int out
as 
set @Sum=@a+@b
declare @kq int
exec sp_Tong 3,4, @kq out
print 'Tong la: ' + cast(@kq as char(10))


--2.
create proc sp_Hieu @a int, @b int, @Hieu int out
as 
set @Hieu=@a-@b
declare @kq int
exec sp_Hieu 4,5, @kq out
print 'Hieu la: ' + cast(@kq as char(10))


--3.
create proc sp_Tich @a int, @b int, @Tich int out
as 
set @Tich=@a*@b
declare @kq int
exec sp_Tich 4,9, @kq out
print 'Tich la: ' + cast(@kq as char(10))

--4.
create proc sp_Thuong @a int, @b int, @Thuong int out
as 
set @Thuong=@a/@b
declare @kq int
exec sp_Thuong 4,2, @kq out
print 'Thuong la: ' + cast(@kq as char(10))



--5.
create proc sp_SoDu @a int, @b int, @Du int out
as 
set @Du=@a%@b
declare @kq int
exec sp_SoDu 6,4, @kq out
print 'So du la: ' + cast(@kq as char(10))


--7.
create proc sp_TongTrongDoan @m int, @n int , @kq int out
as
declare @i int
set @kq=0
set @i=@m
while(@i<=@n)
begin
	set @kq=@kq+@i
	set @i=@i+1
end
go
declare @Tong int
exec sp_TongTrongDoan 4,7, @Tong out
print 'Tong trong doan [4 7] la:' +cast(@Tong as char(10))


--8.
create proc sp_NamNhuan @n int, @kq int out 
as
begin
	if (((@n %4=0) and (@n %100 !=0))or( @n %400=0))
		return 1
	else
		return 0
end
go
declare @Nam int, @kq int
exec @kq=sp_NamNhuan 2017, @Nam out
print @kq



--9.
create proc sp_NamNhuanTrongDoan @m int, @n int,@kq int out
as
declare @i int
set @kq=0
set @i=@m
while(@i<=@n)
begin
	if (@i %4=0 and @i %100 !=0)or( @i %400=0)
		set @kq=@kq+1
	set @i=@i+1
end
declare @KETQUA int
exec sp_NamNhuanTrongDoan 2011,2018, @KETQUA out
print 'So nam nhuan trong doan[2011, 2018] la: '+ cast (@KETQUA as char(10))



 
--10.
create proc sp_DeQuy @n int, @s int out
as
declare @i int
set @s=1
set @i=1
while(@i<=@n)
begin
	set @s=@s*@i
	set @i=@i+1
end
declare @dequy int
exec sp_DeQuy 4, @dequy out
print @dequy

--11.
create proc sp_songay @n date , @kq int out
as
if MONTH(@n) =1 or MONTH(@n)=3 or MONTH(@n)=5 or MONTH(@n)=7 or MONTH(@n)=8 or MONTH(@n)=10 or MONTH(@n)=12
	return 31
if MONTH(@n)=2
	begin
	exec @kq=sp_NamNhuan @n, @kq out
		if @kq=1
			return 29
		else 
			return 28
	end
else 
	return 30
declare @songay int, @ketqua int
exec  @ketqua=sp_songay '1-11-2000' ,@songay out
print 'So ngay trong thang la: '+ cast (@ketqua as char(10))




--12. snt
create proc sp_snt @n int , @kq int out
as
declare @i int
set @i=2
begin
while(@i<=(@n-1))
	if @n % @i=0
		return 0
	else
		return 1
end
go
declare @snt int, @kq int
exec @kq=sp_snt 3,@snt out
print @kq


--14.
create proc sp_scp @n int , @kq int out
as
declare @i int
set @i=0
begin
while(@i * @i <= @n)
	if (@i * @i = @n)
		return 1
	else
	set @i=@i+1
		return 0
end
go
declare @scp int, @kq int
exec @kq=sp_scp 3,@scp out
print @kq

