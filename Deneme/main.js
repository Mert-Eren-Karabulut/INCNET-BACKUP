﻿var myApp = angular.module('myApp', []);

myApp.factory('Avengers', function() {
    var Avengers = {};
    Avengers.cast = [
        {"character":"sagca","name":"Salih Ağca"},
        {"character":"snarin","name":"Samed Narin"},{"character":"cgultekin","name":"Cem Gültekin"},{"character":"ieparlar","name":"Işın Ekin Parlar"},{"character":"sertoran","name":"Sule Ertoran"},{"character":"ckabuloglu","name":"Can Kabuloğlu"},{"character":"ulerol","name":"Ümit Levent Erol"},{"character":"ieaydiner","name":"İlke Esin Aydıner"},{"character":"mtakan","name":"Mehmet Tolga Akan"},{"character":"ngoller","name":"Nazlı Göller"},{"character":"acakal","name":"Ali Çakal"},{"character":"syigiter","name":"Seray Yiğiter"},{"character":"enkarakurt","name":"Elif Naz Karakurt"},{"character":"bbalci","name":"Barış Balcı"},{"character":"dacosar","name":"Durmuş Alptuğ Coşar"},{"character":"kari","name":"Kübra Arı"},{"character":"mkpaker","name":"Mert Kıvanç Paker"},{"character":"amihci","name":"Alp Mıhçı"},{"character":"hbsolak","name":"Hayriye Büşra Solak"},{"character":"stufekci","name":"Şafak Tüfekçi"},{"character":"nkuzuluk","name":"Nisan Kuzuluk"},{"character":"aoarslan","name":"Ata Öz Arslan"},{"character":"ymanav","name":"Yusufcan Manav"},{"character":"aacakici","name":"Ahmet Alp Çakıcı"},{"character":"chamlacibasi","name":"Cem Hamlacıbaşı"},{"character":"hhocaoglu","name":"Helin Hocaoğlu"},{"character":"tozates","name":"Tuğçe Özateş"},{"character":"bsunal","name":"Begüm Sunal"},{"character":"aturkol","name":"Alperen Türkol"},{"character":"snuygun","name":"Sinem Nur Uygun"},{"character":"gasci","name":"Göktuğ Aşçı"},{"character":"imemis","name":"İlayda Memiş"},{"character":"badanali","name":"Berkay Reha Adanalı"},{"character":"takar","name":"Taaralp Akar"},{"character":"yatesoglu","name":"Yunus Cem Ateşoğlu"},{"character":"eaydin","name":"Ezgi Aydın"},{"character":"taydogan","name":"Turaç Aydoğan"},{"character":"ybalci","name":"Yağızhan Balcı"},{"character":"gbatmaz","name":"Güneş Batmaz"},{"character":"bbilginer","name":"Barış Bilginer"},{"character":"vboydak","name":"Vahdet Ertuğrul Boydak"},{"character":"fcan","name":"Fatih Can"},{"character":"cceylan","name":"Cansu Ceylan"},{"character":"ecavlan","name":"Ecem Çavlan"},{"character":"ycicek","name":"Yağız Yaver Çicek"},{"character":"edoganeroglu","name":"Ece Doğaneroğlu"},{"character":"sdurmus","name":"Sercan Durmuş"},{"character":"cergenc","name":"Cenk Ergenç"},{"character":"geskibozkurt","name":"Güner Ege Eskibozkurt"},{"character":"rfidan","name":"Ramazan Fidan"},{"character":"igerkus","name":"İrem Gerkuş"},{"character":"iguger","name":"İrem Güger"},{"character":"iguntut","name":"İnci Güntut"},{"character":"kgurbey","name":"Kerem Gürbey"},{"character":"eguven","name":"Ege Güven"},{"character":"niskan","name":"Nur Gülce İşkan"},{"character":"bkarakaya","name":"Başak Su Karakaya"},{"character":"hkemikli","name":"Hasibe Ceren Kemikli"},{"character":"ckilicoglu","name":"Cağdaş Kılıçoğlu"},{"character":"emert","name":"Ece Mert"},{"character":"amildan","name":"Alara Su Mildan"},{"character":"dovalioglu","name":"Deniz Ovalıoğlu"},{"character":"bonlen","name":"Behiye Begüm Önlen"},{"character":"ekoc","name":"Elif Koç"},{"character":"jpolat","name":"Janset Mehlika Polat"},{"character":"asahin","name":"Ali Deniz Şahin"},{"character":"nsenturk","name":"Nevgül Şenturk"},{"character":"mtakak","name":"Mahir Takak"},{"character":"btogay","name":"Bora Togay"},{"character":"autas","name":"Arif Anil Utaş"},{"character":"hunlu","name":"Halil Utku Ünlu"},{"character":"dyasar","name":"Dora Yaşar"},{"character":"ayilmaz","name":"Ahmet Tugay Yılmaz"},{"character":"myilmaz","name":"Mert Anıl Yılmaz"},{"character":"mzorlu","name":"Merve Eylül Zorlu"},{"character":"eogezer","name":"Ege Onat Gezer"},{"character":"nybulut","name":"Nurdan Yağmur Bulut"},{"character":"bkerim","name":"Batuhan Kerim"},{"character":"dacikgoz","name":"Deniz Açıkgöz"},{"character":"aakgun","name":"Alkım Akgün"},{"character":"balyesil","name":"Berfin Alyeşil"},{"character":"ibagac","name":"İlayda Bagaç"},{"character":"vbalci","name":"Volkan Balcı"},{"character":"abasar","name":"Akıncan Başar"},{"character":"bbaskan","name":"Bade Başkan"},{"character":"eubatur","name":"Enver Utku Batur"},{"character":"ebbilgili","name":"Ege Berkin Bilgili"},{"character":"obolat","name":"Özgur Bolat"},{"character":"ibozdemir","name":"İbrahim Bozdemir"},{"character":"ncikrikci","name":"Nese Çıkrıkçı"},{"character":"ddemir","name":"Damla Demir"},{"character":"bdemirel","name":"Barış Demirel"},{"character":"hsdinc","name":"Hazal Su Dinç"},{"character":"hdingenc","name":"Hakan Dingenç"},{"character":"uoercan","name":"Uğur Orhun Ercan"},{"character":"ferduran","name":"Ferhat Erduran"},{"character":"ibgedizlioglu","name":"İhsan Barış Gedizlioglu"},{"character":"cengizgur","name":"Cengiz Gür"},{"character":"dgureler","name":"Deniz Güreler"},{"character":"ginanc","name":"Gamze İnanç"},{"character":"eekarabiyik","name":"Emir Eray Karabıyık"},{"character":"mskarabulut","name":"Mehmet Semih Karabulut"},{"character":"ykasap","name":"Yağmur Kasap"},{"character":"skaytan","name":"Sevin Kaytan"},{"character":"okocer","name":"Onur Koçer"},{"character":"bdkurban","name":"Buse Dide Kurban"},{"character":"skurtulmus","name":"Sinan Kurtulmuş"},{"character":"mukucukvar","name":"Muhammed Umut Küçükvar"},{"character":"eomeroglu","name":"Eren Ömeroglu"},{"character":"foncul","name":"Fem Öncul"},{"character":"ofonder","name":"Ömer Fahri Önder"},{"character":"gozge","name":"Görkem Özge"},{"character":"fozkan","name":"Fatma Özkan"},{"character":"bcozmen","name":"Berk Can Özmen"},{"character":"rozturk","name":"Rima Öztürk"},{"character":"tparlan","name":"Tolga Parlan"},{"character":"ocpasaoglu","name":"Osman Ceyhun Paşaoğlu"},{"character":"gdpinarlik","name":"Güldane Damla Pınarlık"},{"character":"mpolat","name":"Murat Polat"},{"character":"usaracoglu","name":"Utku Saraçoğlu"},{"character":"iesayin","name":"İrem Ekin Sayın"},{"character":"aselekoglu","name":"Ataberk Selekoğlu"},{"character":"osahin","name":"Ömer Şahin"},{"character":"dsahin","name":"Deniz Şahin"},{"character":"gsendemir","name":"Gülfem Şendemir"},{"character":"mtaskiran","name":"Mert Taşkıran"},{"character":"atoygar","name":"Alper Toygar"},{"character":"ikturan","name":"İlteriş Kağan Turan"},{"character":"duresin","name":"Duygu Üresin"},{"character":"ohvarli","name":"Oğulcan Hasan Varlı"},{"character":"bzadeoglu","name":"Baran Zadeoğlu"},{"character":"oeacar","name":"Özgem Elif Acar"},{"character":"ouacarli","name":"Onur Ulaş Acarlı"},{"character":"gaksit","name":"Gökdeniz Akşit"},{"character":"gsaltintas","name":"Gül Sena Altıntaş"},{"character":"taavsar","name":"Taylan Adar Avşar"},{"character":"baytac","name":"Berke Aytaç"},{"character":"mudursun","name":"Mustafa Uğur Dursun"},{"character":"bergun","name":"Begüm Ergün"},{"character":"kkkocaman","name":"Kadir Kaan Kocaman"},{"character":"oonacitarhan","name":"Özgün Ozan Nacitarhan"},{"character":"dsarac","name":"Defne Saraç"},{"character":"ssahan","name":"Sevde Şahan"},{"character":"uetuluk","name":"Utku Ege Tuluk"},{"character":"byalcin","name":"Bora Yalçın"},{"character":"szagra","name":"Şimal Zağra"},{"character":"oarda","name":"Okan Arda"},{"character":"sarpaci","name":"Selin Arpacı"},{"character":"ebalci","name":"Ekin Balcı"},{"character":"kbbaskaya","name":"Kemal Batuhan Başkaya"},{"character":"ibayazitli","name":"İlke Bayazıtlı"},{"character":"ocayci","name":"Onur Çaycı"},{"character":"cergurbuz","name":"Cansu Ergürbüz"},{"character":"biscanli","name":"Baran İşcanlı"},{"character":"fozgur","name":"Fikrican Özgür"},{"character":"epolat","name":"Erkin Polat"},{"character":"evaran","name":"Engincan Varan"},{"character":"eyaman","name":"Esra Yaman"},{"character":"syatarkalkmaz","name":"Sezen Yatarkalkmaz"},{"character":"ecyazici","name":"Ege Can Yazıcı"},{"character":"fakyol","name":"Furkan Akyol"},{"character":"batalay","name":"Bengisu Atalay"},{"character":"hcoban","name":"Heval Çoban"},{"character":"sydogan","name":"Selen Yade Doğan"},{"character":"dshaliloglu","name":"Dilruba Sultan Haliloğlu"},{"character":"bkaraman","name":"Berfin Karaman"},{"character":"dsabak","name":"Dadlez Sabak"},{"character":"cozbas","name":"Cumhur Özbaş"},{"character":"bsimsek","name":"Barkın Şimşek"},{"character":"etulu","name":"Ezgi Tülü"},{"character":"afyilmaz","name":"Arifcan Faik Yılmaz"},{"character":"bnyilmaz","name":"Bilge Nur Yılmaz"},{"character":"dzyorgancioglu","name":"Defne Zuhal Yorgancıoğlu"},{"character":"sakgun","name":"Sena Akgün"},{"character":"aoates","name":"Azmi Ozan Ateş"},{"character":"bavci","name":"Barışcan Avcı"},{"character":"ebayramgurler","name":"Efe Bayramgüler"},{"character":"tcinay","name":"Timur Cinay"},{"character":"okaratas","name":"Özge Karataş"},{"character":"ekarayel","name":"Ezgi Karayel"},{"character":"dongun","name":"Destina Ongun"},{"character":"dsaygili","name":"Dilara Saygılı"},{"character":"msengeldi","name":"Mısra Şengeldi"},{"character":"ictutulmazay","name":"İzzet Can Tutulmazay"},{"character":"yunal","name":"Yağmur Ünal"},{"character":"kvarolgunes","name":"Kendal Varolgüneş"},{"character":"ebyuzbas","name":"Ege Berent Yüzbaş"},{"character":"mmeric","name":"Melih Meric"},{"character":"msait","name":"Mahir Sait"},{"character":"ggurcavdi","name":"Gökçe Gürçavdı"},{"character":"obsunal","name":"Onur Berk Sunal"},{"character":"ykaraman","name":"Yusuf Karaman"},{"character":"adamar","name":"Aysu Damar"},{"character":"bakcetin","name":"Bahriye Akçetin"},{"character":"ctterzi","name":"Cem Tuna Terzi"},{"character":"ahelliwell","name":"Almira Helliwell"},{"character":"ehelliwell","name":"Ela Helliwell"},{"character":"dihelliwell","name":"Dilara Helliwell"},{"character":"kgok","name":"Kıvanç Gök"},{"character":"iguler","name":"İlknur Güler"},{"character":"eguler","name":"Erdal Güler"},{"character":"zdumlupinar","name":"Zehni Dumlupınar"},{"character":"isguler","name":"Işılay Güler"},{"character":"bguler","name":"Berkay Güler"},{"character":"aciftci","name":"Ayşe Çiftçi"},{"character":"cciftci","name":"Cansu Çiftçi"},{"character":"uyildirim","name":"Umut Yıldırım"},{"character":"mcetin","name":"Muhammet Çetin"},{"character":"ryurtseven","name":"Remziye Yurtseven"},{"character":"hhepisler","name":"Hilal Hepişler"},{"character":"steke","name":"Samet Teke"},{"character":"maydos","name":"Mustafa Aydos"},{"character":"fdaskin","name":"Figen Daşkın"},{"character":"ebingol","name":"Esin Bingöl"},{"character":"esahinbas","name":"Ergin Şahinbaş"},{"character":"dgulyurt","name":"Deniz Gülyurt"},{"character":"cgurses","name":"Can Gürses"},{"character":"adheper","name":"Akın Deniz Heper"},{"character":"eicen","name":"Elif İçen"},{"character":"skaya","name":"Selda Kaya"},{"character":"aunlu","name":"Ali Ünlü"},{"character":"chostetler","name":"Christina Louise Hostetler"},{"character":"saytac","name":"Şaban Aytaç"},{"character":"shbelikirik","name":"Sandrine Belikırık"},{"character":"asunlu","name":"Aslı Ünlü"},{"character":"ayagci","name":"Ayça Yağcı"},{"character":"aerden","name":"Agin Erden"},{"character":"baniker","name":"Betül Anıker"},{"character":"aarbay","name":"Ayça Arbay"},{"character":"taydin","name":"Tunakan Aydın"},{"character":"ebahadir","name":"Erdem Bahadır"},{"character":"bdbasarer","name":"Berk Deniz Başarer"},{"character":"rbastimar","name":"Ruken Baştımar"},{"character":"mobaykan","name":"Mehmet Ozan Baykan"},{"character":"sbayram","name":"Senanur Bayram"},{"character":"sbeldag","name":"Serra Beldağ"},{"character":"atcertel","name":"Alperen Taha Certel"},{"character":"ccoskunpinar","name":"Çağlar Coşkunpınar"},{"character":"zcekinmez","name":"Zeynep Çekinmez"},{"character":"gcetin","name":"Gülçin Çetin"},{"character":"acoban","name":"Ayşe Çoban"},{"character":"pdemir","name":"Pelinsu Demir"},{"character":"adikici","name":"Ada Dikici"},{"character":"tdincer","name":"Tuna Dinçer"},{"character":"sbdolancay","name":"Şilan Berfin Dolançay"},{"character":"ekduman","name":"Ege Kaan Duman"},{"character":"niduman","name":"Nazlı İdil Duman"},{"character":"eeren","name":"Ege Eren"},{"character":"hsergelen","name":"Hazal Sabiha Ergelen"},{"character":"ddergen","name":"Derya Deniz Ergen"},{"character":"aagevsek","name":"Asena Ayşe Gevşek"},{"character":"gcgonuller","name":"Göktuğ Çağlar Gönüller"},{"character":"edgul","name":"Elif Dilge Gül"},{"character":"ocipekten","name":"Ozan Cengiz İpekten"},{"character":"gekarboga","name":"Gevher Eylül Karboğa"},{"character":"kkoc","name":"Korcan Koç"},{"character":"bkurt","name":"Başak Kurt"},{"character":"nkukurtcu","name":"Nazlıcan Kükürtcü"},{"character":"mkmeral","name":"Murat Kaan Meral"},{"character":"bmutlu","name":"Buket Mutlu"},{"character":"mokyay","name":"Mert Okyay"},{"character":"nnoruc","name":"Nefle Nesli Oruç"},{"character":"faoyal","name":"Fuat Alperen Oyal"},{"character":"conelge","name":"Çetincan Önelge"},{"character":"heoz","name":"Hatice Ece Öz"},{"character":"aozoner","name":"Alper Özöner"},{"character":"iiozyigit","name":"Irmak İrem Özyiğit"},{"character":"asarikaya","name":"Anıl Sarıkaya"},{"character":"ymsay","name":"Yağız Muratcan Say"},{"character":"ssan","name":"Şebnem Şan"},{"character":"otasdemir","name":"Orçun Taşdemir"},{"character":"dtonkur","name":"Doğu Tonkur"},{"character":"atuncer","name":"Atahan Tuncer"},{"character":"eyturan","name":"Elif Yağmur Turan"},{"character":"zstuzun","name":"Zeynep Serra Tüzün"},{"character":"guslu","name":"Gülşah Uslu"},{"character":"buzunonat","name":"Berk Uzunonat"},{"character":"iunveren","name":"İrem Ünveren"},{"character":"kyanik","name":"Kağan Yanık"},{"character":"mdyapsik","name":"Mehmet Deniz Yapsık"},{"character":"kayildizkan","name":"Konur Alp Yıldızkan"},{"character":"meyilmaz","name":"Mert Efe Yılmaz"},{"character":"ezurap","name":"Erkay Zürap"},{"character":"vyildizli","name":"Verda Yıldızlı"},{"character":"aeagacıklar","name":"Ayşegül Eylül Ağacıklar"},{"character":"aeyildirim","name":"Ali Eren Yıldırım"},{"character":"iyeniceli","name":"İlayda Yeniceli"},{"character":"daksen","name":"Doğa Aksen"},{"character":"aaksoy","name":"Aslı Aksoy"},{"character":"oyel","name":"Onur Yel"},{"character":"boyarar","name":"Baran Ozan Yarar"},{"character":"osaltın","name":"Özgür Şahin Altın"},{"character":"kyanginci","name":"Kemal Yangıncı"},{"character":"tyalcin","name":"Tuncer Yalçın"},{"character":"baltintop","name":"Buğra Altıntop"},{"character":"melisyalcin","name":"Melis Yalçın"},{"character":"tyagan","name":"Tuana Yağan"},{"character":"dsunluakin","name":"Dide Su Ünlüakın"},{"character":"haaltunsaray","name":"Heval Ayşe Altunsaray"},{"character":"bturkkani","name":"Berk Türkkanı"},{"character":"dtumkaya","name":"Demet Tümkaya"},{"character":"batuhanavci","name":"Batuhan Avcı"},{"character":"dturan","name":"Deniz Turan"},{"character":"gtopal","name":"Görkem Topal"},{"character":"bay","name":"Beril Ay"},{"character":"ugtiryaki","name":"Ünal Güneş Tiryaki"},{"character":"aaydin","name":"Arda Aydın"},{"character":"tbtemur","name":"Taha Berk Temur"},{"character":"ebarut","name":"Ezgi Barut"},{"character":"dboz","name":"Deniz Boz"},{"character":"ysimsek","name":"Yağmur Şimşek"},{"character":"ansansli","name":"Ayşe Naz Şanslı"},{"character":"eecengiz","name":"Elzem Eylül Cengiz"},{"character":"tsanal","name":"Tanya Şanal"},{"character":"mhcekic","name":"Mehmet Hayri Çekiç"},{"character":"ndsivrioglu","name":"Nesibe Derin Sivrioğlu"},{"character":"aesert","name":"Ahmet Ege Sert"},{"character":"abcetin","name":"Ayşah Birçe Çetin"},{"character":"ubranda","name":"Ulaş Baran Randa"},{"character":"ipikbay","name":"İsa Pikbay"},{"character":"ksozturk","name":"Kerem Serdar Öztürk"},{"character":"fbmardin","name":"Fidel Berdan Demir"},{"character":"uyozulku","name":"Ünal Yiğit Özülkü"},{"character":"zsozturk","name":"Zeynep Sultan Öztürk"},{"character":"aozturk","name":"Atahan Öztürk"},{"character":"iozdemir","name":"İlayda Özdemir"},{"character":"ldeniz","name":"Lara Deniz"},{"character":"toflaz","name":"Tatul Oflaz"},{"character":"yesme","name":"Yaren Eşme"},{"character":"slokmanoglu","name":"Sude Lokmanoğlu"},{"character":"ykuzucu","name":"Yaren Kuzucu"},{"character":"efeyzioglu","name":"Ege Feyzioğlu"},{"character":"skolsuz","name":"Selin Kolsuz"},{"character":"gkenanoglu","name":"Göksu Kenanoğlu"},{"character":"ykaklikkaya","name":"Yavuz Kaklıkkaya"},{"character":"bfiliz","name":"Berke Filiz"},{"character":"eispirlioglu","name":"Ergin İspirlioğlu"},{"character":"hiinci","name":"Hafize Işıksu İnci"},{"character":"kgorgun","name":"Kutay Gorgun"},{"character":"ugüvenc","name":"Ufuk Güvenç"},{"character":"zgunay","name":"Zeynep Günay"},{"character":"gincesu","name":"Gizem İncesu"},{"character":"ggunes","name":"Göknur Güneş"},{"character":"celitog","name":"Cafer Elitoğ"},{"character":"dcteke","name":"Dilara Çarşanlı Teke"},{"character":"ddworak","name":"Douglas Dworak"},{"character":"huluoglu","name":"Habib Uluoğlu"},{"character":"scagan","name":"Selçuk Çağan"},{"character":"hyucel","name":"Hamza Yücel"},{"character":"ijurilj","name":"Igor JURILJ"},{"character":"idemirbas","name":"İbrahim Demirbaş"},{"character":"jmcgowan","name":"Joe Mcgowan"},{"character":"kkaydos","name":"Kübra Aydos"},{"character":"smcgowan","name":"Sherry Mcgowan"},{"character":"zleskovac","name":"Zeljka Leskovac"},{"character":"zkilic","name":"Zeynep Kılıç"}];
    return Avengers;
})

function AvengersCtrl($scope, Avengers) {
    $scope.avengers = Avengers;
}

myApp.directive('yeah', function(){
   return{

       restrict:'E',
       template:'<h1> U shld knw who im!!</h1>' 


   }
});