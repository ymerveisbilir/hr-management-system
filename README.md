# İnsan Kaynakları Yönetim Sistemi (İKYS)

## 📌 Projenin Amacı
Bu proje, çalışanların bilgi, belge ve izin taleplerini yönetmesini sağlayan bir sistemdir.  
Superadmin tüm kullanıcıları ve süreçleri tek panelden yönetebilir. Kullanıcılar yalnızca kendi bilgilerini görebilir ve izin başvurusu yapabilir.

---

## 🧑‍💼 Sistem Rollerimiz
- **Superadmin:** Sistemin tüm yönetim işlemlerini yapar.  
- **Kullanıcı:** Sisteme Superadmin tarafından eklenen personeldir.

---

## 📂 Modüller

### 1. Kullanıcı Yönetimi (Superadmin Paneli)

Kullanıcılar  
- Harici kayıt (register) özelliği yoktur.  
- Sadece Superadmin kullanıcı ekleyebilir, düzenleyebilir ve silebilir.  
- Superadmin, kullanıcılar ekranında sadece kendisine bağlı kullanıcıları görür.  
- Yeni kullanıcı eklerken aşağıdaki bilgiler girilir:  
  - İsim, Soyisim, E-posta, Şifre  
  - Ünvan (Pozisyon)  
  - İzin onaylayıcısı (Bu kullanıcının izin taleplerini onaylayacak kişi)  

Tanımlamalar (Yalnızca Superadmin tarafından yapılır)  
- İzin Türleri  
- Cihazlar  
- Dosya Türleri  
- Zimmetler (emanet cihaz, ekipman vb.)  
- Dosyalar (Sözleşme, Sertifika, Evrak vb.)  

---

### 2. Kullanıcı Dashboard (Kullanıcı Girişi Sonrası)

Hesabım - Şifre & Güvenlik  
- Kullanıcı adı, soyadı, şifre, ünvanı ve kişisel bilgilerini görüntüler.  
- Kullanıcı bu bilgileri düzenleyebilir.  

İzin Taleplerim  
- Kullanıcı daha önce oluşturduğu izin taleplerini görüntüler.  
- Yeni izin talebi oluşturabilir:  
  - İzin başlangıç ve bitiş tarihi  
  - İzin türü (Yıllık izin, Mazeret izni vb.)  
  - Açıklama alanı  
- İzin talebi, sistemde belirlenen onaylayıcıya iletilir.  

İzin Talepleri (Onay Ekranı)  
- Eğer kullanıcı onaylayıcı ise, kendisine bağlı personelin izin taleplerini görüntüler.  
- Talepleri onaylayabilir veya reddedebilir.  
- Superadmin, kullanıcı eklerken bu kullanıcının hangi izinleri onaylayacağını belirler.  

Zimmetlerim  
- Superadmin tarafından girilen zimmetler (emanet cihaz, laptop, telefon, ekipman vb.) listelenir.  
- Kullanıcı sadece kendi zimmetlerini görüntüleyebilir.  

Dosyalarım  
- Superadmin’in eklediği sözleşme, sertifika, evrak vb. dosyalar listelenir.  
- Dosyalar kategorilere (Sertifikalar, Sözleşmeler, Diğer) ayrılabilir.  

---

## 🔗 İlişki Yapısı
- Superadmin ➜ Kullanıcı oluşturur ➜ Kullanıcı kendi dashboard’una erişir.  
- Kullanıcı ➜ İzin başvurusu yapar ➜ İzin onaylayıcı onaylar veya reddeder.  
- Superadmin ➜ Kullanıcılara zimmet ve dosya atar ➜ Kullanıcılar kendi zimmet ve dosyalarını görür.  
- İzin onaylayıcıları ➜ Sadece yetkili oldukları kullanıcıların izinlerini görür.  

---

## 🛠 Kullanılan Teknolojiler
- **Backend:** Laravel 12  
- **Frontend:** Bootstrap / Vuexy Theme  
- **Veritabanı:** MySQL  
- **Diğer:** Select2, jQuery, npm, composer

