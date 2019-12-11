<?php

use App\Models\Staff\JobTitle;
use Illuminate\Database\Seeder;

class JobTitlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->makeJobTitle('Academic', 'Graduate Assistant I', 'Level I');
        $this->makeJobTitle('Academic', 'Graduate Assistant II', 'Level I');
        $this->makeJobTitle('Academic', 'Assistant Lecturer', 'Level I');
        $this->makeJobTitle('Academic', 'Lecturer', 'Level I');
        $this->makeJobTitle('Academic', 'Assistant Professor', 'Level I');
        $this->makeJobTitle('Academic', 'Associate Professor', 'Level I');
        $this->makeJobTitle('Academic', 'Professor', 'Level I');

        $this->makeJobTitle('Administrative', 'ፕሬዚዳንት ጽ/ቤት ሀላፊ', 'Level XVIII');
        $this->makeJobTitle('Administrative', 'ዳይሬክተር III', 'Level XVI');
        $this->makeJobTitle('Administrative', 'ኤክስኪዩቲቭ ስክሬተሪ III', 'Level XI');
        $this->makeJobTitle('Administrative', 'ኤክስኪዩቲቭ ስክሬተሪ I', 'Level IX');
        $this->makeJobTitle('Administrative', 'ኤክስኪዩቲቭ ስክሬተሪ II', 'Level X');
        $this->makeJobTitle('Administrative', 'ሴክሬታሪ II', 'Level VIII');
        $this->makeJobTitle('Administrative', 'ሴክሬታሪ I', 'Level VII');
        $this->makeJobTitle('Administrative', 'ተላላኪ', 'Level II');
        $this->makeJobTitle('Administrative', 'ሾፌር III', 'Level VIII');
        $this->makeJobTitle('Administrative', 'ሾፌር II', 'Level VII');
        $this->makeJobTitle('Administrative', 'ሾፌር I', 'Level VI');
        $this->makeJobTitle('Administrative', 'የእቅድ ዝግጅት ክትትልና ግምገማ ባለሙያ IV', 'Level XII');
        $this->makeJobTitle('Administrative', 'የበጀት ዝግጅትና ክትትል ባለሙያ II', 'Level IX');
        $this->makeJobTitle('Administrative', 'የበጀት ዝግጅትና ክትትል ባለሙያ III', 'Level XI');
        $this->makeJobTitle('Administrative', 'የውጪ ግንኙነትና ኮምኒኬሽን ባለሙያ  IV', 'Level XIII');
        $this->makeJobTitle('Administrative', 'የህዝብ ግንኙነትና ኮሙኒኬሽን ባለሙያ IV', 'Level XII');
        $this->makeJobTitle('Administrative', 'የመረጃ ደስክ ሰራተኛ I', 'Level V');
        $this->makeJobTitle('Administrative', 'የስነ  ፅሁፍ ባለሙያ  III', 'Level XI');
        $this->makeJobTitle('Administrative', 'ካሜራማን III', 'Level VIII');
        $this->makeJobTitle('Administrative', 'የስብሰባዎችና አውደ ጥናቶች አመቻች ሰራተኛ II', 'Level VII');
        $this->makeJobTitle('Administrative', 'ሰርኩሌሽን ሰራተኛ  III', 'Level VII');
        $this->makeJobTitle('Administrative', 'ሰርኩሌሽን ሰራተኛ  II', 'Level VI');
        $this->makeJobTitle('Administrative', 'የሰርኩሌሽን ክፍል ፈረቃ አስተባባሪ', 'Level IX');
        $this->makeJobTitle('Administrative', 'የቤተ መፃህፍት ፍተሻ ሠራተኛ', 'Level IV');
        $this->makeJobTitle('Administrative', 'የፒሪዮዲካልና ዶክሜንቴሽን  ሠራተኛ', 'Level VII');
        $this->makeJobTitle('Administrative', 'የፎቶ ኮፒና ማባዣ ሠራተኛ I', 'Level III');
        $this->makeJobTitle('Administrative', 'የተማሪዎች ቅበላና ምዝገባ ባለሙያ II', 'Level IX');
        $this->makeJobTitle('Administrative', 'የወጪ መጋራት ክትትል ባለሙያ II', 'Level IX');
        $this->makeJobTitle('Administrative', 'የመረጃ ሥራ አመራር ባለሙያ III', 'Level X');
        $this->makeJobTitle('Administrative', 'የሲስተም አድሚኒስትሬተር III', 'Level XI');
        $this->makeJobTitle('Administrative', 'ዲጂታል ላይብራሪ አሲስታንት', 'Level VII');
        $this->makeJobTitle('Administrative', 'የጥበቃ ሠራተኛ  I', 'Level III');
        $this->makeJobTitle('Administrative', 'የሰርኩሌሽን አገልግሎት አስተባባሪ', 'Level XII');
        $this->makeJobTitle('Administrative', 'የሪፈረንስና ኢንተርኔት አገልግሎት አስተባባሪ', 'Level XII');
        $this->makeJobTitle('Administrative', 'ካታሎጊግና ክላሲፊኬሽን ባለሙያ III', 'Level XI');
        $this->makeJobTitle('Administrative', 'ካታሎገር', 'Level IX');
        $this->makeJobTitle('Administrative', 'የአኩዚሽን ባለሙያ III', 'Level XI');
        $this->makeJobTitle('Administrative', 'ቢቢሊዮግራፈር ኢንዴክሰር', 'Level VII');
        $this->makeJobTitle('Administrative', 'የመፃህፍት ድጎሣና ጥረዛ ሠራተኛ', 'Level IV');
        $this->makeJobTitle('Administrative', 'ሰርኩሌሽን ሠራተኛ III', 'Level VII');
        $this->makeJobTitle('Administrative', 'ረዳት አስተዳደር', 'Level XIII');
        $this->makeJobTitle('Administrative', 'የምርምር ሪሶርስ ማዕከል ሠራተኛ', 'Level VII');
        $this->makeJobTitle('Administrative', 'ትራክተር ኦፕሬተር', 'Level VIII');
        $this->makeJobTitle('Administrative', 'የልዩ ተሽከርካሪ ረዳት', 'Level III');
        $this->makeJobTitle('Administrative', 'የተቀናጀ የምርምር ማዕከል አስተባባሪ', 'Level XIV');
        $this->makeJobTitle('Administrative', 'የእንስሳት  እርባታ ባለሙያ II', 'Level X');
        $this->makeJobTitle('Administrative', 'የሰብል ልማት ባለሙያ /አግሮኖሚስት/ II', 'Level X');
        $this->makeJobTitle('Administrative', 'የደን ሀብት ልማት ባለሙያ II', 'Level IX');
        $this->makeJobTitle('Administrative', 'የጥበቃ ሠራተኛ  II', 'Level IV');
        $this->makeJobTitle('Administrative', 'ጽዳት ሠራተኛ II', 'Level III');
        $this->makeJobTitle('Administrative', 'የሽያጭ ሠራተኛ I', 'Level VI');
        $this->makeJobTitle('Administrative', 'የጉልበት ሠራተኛ', 'Level III');
        $this->makeJobTitle('Administrative', 'የህግ ባለሙያ III', 'Level XII');
        $this->makeJobTitle('Administrative', 'የህግ ባለሙያ IV', 'Level XIV');
        $this->makeJobTitle('Administrative', 'የአዲስ አበባ ማስተባበሪያ ጽቤት አስተባባሪ', 'Level XIV');
        $this->makeJobTitle('Administrative', 'የአዲስ አበባ ማስተባበሪያ ጽቤት ባለሙያ II', 'Level IX');
        $this->makeJobTitle('Administrative', 'የሥነ-ምግባር መኮንን IV', 'Level XII');
        $this->makeJobTitle('Administrative', 'የአቤቱታና ቅሬታ ማስተናገጃ ባለሙያ III', 'Level X');
        $this->makeJobTitle('Administrative', 'የሥነ-ምግባር መኮንን  III', 'Level XI');
        $this->makeJobTitle('Administrative', 'የሥነ-ምግባር መኮንን  II', 'Level X');
        $this->makeJobTitle('Administrative', 'የለውጥና መልካም አስተዳደር ባለሙያ III', 'Level XI');
        $this->makeJobTitle('Administrative', 'የለውጥና መልካም አስተዳደር ባለሙያ IV', 'Level XII');
        $this->makeJobTitle('Administrative', 'የእቃ ግምጃ ቤት ኃላፊ I', 'Level IX');
        $this->makeJobTitle('Administrative', 'የኢንፎርሜሽን ኮምዩኒኬሽን ቴክኖሎጂ መሠረተ ልማትና አስተዳደር ቡድን መሪ', 'Level XIV');
        $this->makeJobTitle('Administrative', 'የኔት ወርክ አድሚኒስትሬተር I', 'Level VIII');
        $this->makeJobTitle('Administrative', 'የኔትወርክ አድሚኒስትሬተር  II', 'Level IX');
        $this->makeJobTitle('Administrative', 'የኔት ወርክ አድምንስትሬተር IV', 'Level XIII');
        $this->makeJobTitle('Administrative', 'የሲስተም አድሚኒስትሬተር I', 'Level VIII');
        $this->makeJobTitle('Administrative', 'ሲስተም  አድሚኒስትሬተር II', 'Level IX');
        $this->makeJobTitle('Administrative', 'የሲስተም አድሚኒስትሬተር IV', 'Level XII');
        $this->makeJobTitle('Administrative', 'የአፕልኬሽን ልማትና አስተዳደር ቡድን መሪ', 'Level XIV');
        $this->makeJobTitle('Administrative', 'የሶፍትዌር ፕሮግራመር II', 'Level IX');                  // unknown
        $this->makeJobTitle('Administrative', 'ሶፍትዌር ፕሮግራመር III', 'Level XI');
        $this->makeJobTitle('Administrative', 'የሶፍትዌር ፕሮግራመር IV', 'Level XIII');
        $this->makeJobTitle('Administrative', 'የዳታ ቤዝ አድሚኒስትሬተር IV', 'Level XIII');
        $this->makeJobTitle('Administrative', 'ሲስተም አናሊስት I', 'Level VIII');
        $this->makeJobTitle('Administrative', 'ሲስተም አናሊስት IV', 'Level XIII');
        $this->makeJobTitle('Administrative', 'የመማር ማስተማርና  የቴክኖሎጂ ቡድን መሪ', 'Level XIV');
        $this->makeJobTitle('Administrative', 'የቪዲዮ ኮንፍረንስ ቴክኒሺያን', 'Level X');
        $this->makeJobTitle('Administrative', 'የኢለርኒግ ባለሙያ II', 'Level IX');
        $this->makeJobTitle('Administrative', 'የዌብ ሳይት አድሚኒስትሬተር IV', 'Level XIII');
        $this->makeJobTitle('Administrative', 'የኮንቴንት ልማት ባለሙያ  III', 'Level XI');
        $this->makeJobTitle('Administrative', 'ቴክኒካል ድጋፍ ሰጪ ጥገና ቡድን መሪ', 'Level XIV');
        $this->makeJobTitle('Administrative', 'ኮምፒዩተር ጥገና ቴክኒሺያን I', 'Level VII');
        $this->makeJobTitle('Administrative', 'ኮምፒዩተር ጥገና ቴክኒሺያን II', 'Level VIII');
        $this->makeJobTitle('Administrative', 'ኮምፒዩተር ጥገና ቴክኒሺያን III', 'Level IX');
        $this->makeJobTitle('Administrative', 'የትምህርትና ሥልጠና ቡድን መሪ', 'Level XIV');
        $this->makeJobTitle('Administrative', 'የትምህርትና ሥልጠና ባለሙያ II', 'Level IX');
        $this->makeJobTitle('Administrative', 'የትምህርት ጥራት ቁጥጥርና ማሻሻያ ባለሙያ IV', 'Level XIII');
        $this->makeJobTitle('Administrative', 'አልሙናይ  ሪከርድና አግልግሎት ባለሙያ lV', 'Level XI');
        $this->makeJobTitle('Administrative', 'ፋይናንሻል ኦዲት ቡድን መሪ III', 'Level XV');
        $this->makeJobTitle('Administrative', 'የፋይናንሽያል ኦዲት ባለሙያ III', 'Level XI');
        $this->makeJobTitle('Administrative', 'የክዋኔ ኦዲት ቡድን መሪ III', 'Level XV');
        $this->makeJobTitle('Administrative', 'የክዋኔ የኦዲት ባለሙያ IV', 'Level XII');
        $this->makeJobTitle('Administrative', 'የክዋኔ የኦዲት ባለሙያ III', 'Level XI');
        $this->makeJobTitle('Administrative', 'የሴቶችና ህጻናት  ጉዳይ ቡድን መሪ II', 'Level XIV');
        $this->makeJobTitle('Administrative', 'የሴቶች ጉዳይ ባለሙያ IV', 'Level XII');
        $this->makeJobTitle('Administrative', 'የሴቶች ጉዳይ ባለሙያ III', 'Level XI');
        $this->makeJobTitle('Administrative', 'የሴቶች ጉዳይ ባለሙያ II', 'Level IX');
        $this->makeJobTitle('Administrative', 'የህጻናት ጉዳይ ባለሙያ IV', 'Level XII');
        $this->makeJobTitle('Administrative', 'የህጻናት ጉዳይ ባለሙያ III', 'Level XI');
        $this->makeJobTitle('Administrative', 'የህጻናት ጉዳይ ባለሙያ II', 'Level IX');
        $this->makeJobTitle('Administrative', 'የወጣቶች ጉዳይ ቡድን መሪ II', 'Level XIV');
        $this->makeJobTitle('Administrative', 'የወጣቶች ጉዳይ ባለሙያ IV', 'Level XII');
        $this->makeJobTitle('Administrative', 'የወጣቶች ጉዳይ ባለሙያ III', 'Level XI');
        $this->makeJobTitle('Administrative', 'የወጣቶች ጉዳይ ባለሙያ II', 'Level IX');
        $this->makeJobTitle('Administrative', 'የኤች አይ ቪ ኤድስ ጉዳዩች ባለሞያ II', 'Level IX');
        $this->makeJobTitle('Administrative', 'የፊልም እና መዝናኛ ሠራተኛ', 'Level III');
        $this->makeJobTitle('Administrative', 'የምክትል ፕሬዚዳንት ልዩ ረዳት', 'Level XVI');
        $this->makeJobTitle('Administrative', 'የህግ ባለሙያ II', 'Level XI');
        $this->makeJobTitle('Administrative', 'የግዥ ቡድን መሪ I', 'Level XIII');
        $this->makeJobTitle('Administrative', 'የግዥ ሠራተኛ II', 'Level VII');
        $this->makeJobTitle('Administrative', 'የባህል ማዕከል ኃላፊ', 'Level X');                      // unsure
        $this->makeJobTitle('Administrative', 'የቲያትር ባለሙያ III', 'Level XI');
        $this->makeJobTitle('Administrative', 'የሥነ-ጽሁፍ ባለሙያ I', 'Level VIII');
        $this->makeJobTitle('Administrative', 'የባህል ጥናት ባለሙያ III', 'Level XII');
        $this->makeJobTitle('Administrative', 'የግእዝ ቋንቋ ጥናት ባለሙያ III', 'Level XII');
        $this->makeJobTitle('Administrative', 'ማኑስክሪኘት አርካይቪስት III', 'Level VIII');
        $this->makeJobTitle('Administrative', 'የተከታታይና ርቀት ትምህርት ፕሮግርም ምክትትል ዳይሬክተር', 'Level XV');
        $this->makeJobTitle('Administrative', 'የተከታታይና ርቀት ትምህርት ባለሙያ IV', 'Level XIII');
        $this->makeJobTitle('Administrative', 'የርቀት ትምህርት ባለሙያ IV/ለደብረ ብርሃን/', 'Level XIII');
        $this->makeJobTitle('Administrative', 'የርቀት ትምህርት ባለሙያ  IV/ለሸዋሮቢት/', 'Level XIII');
        $this->makeJobTitle('Administrative', 'የርቀት ትምህርት ባለሙያ  IV/ለዓለም ከተማ/', 'Level XIII');
        $this->makeJobTitle('Administrative', 'የሞጁል፣ ፈተናና አሳይንመንት ዝግጅትና ስርጭት ባለሙያ', 'Level X');
        $this->makeJobTitle('Administrative', 'የመረጃ ሥራ አመራር ባለሙያ III', 'Level X');
        $this->makeJobTitle('Administrative', 'የርቀት ትምህርት ባለሙያ  IV/ለአዲስ አበባ/', 'Level XIII');
        $this->makeJobTitle('Administrative', 'የተማሪዎች ቅበላና ምዝገባ ቡድን መሪ', 'Level XIII');
        $this->makeJobTitle('Administrative', 'የህትመት ቡድን መሪ', 'Level XIII');
        $this->makeJobTitle('Administrative', 'የህትመት ማሽን መካኒክ I', 'Level VII');
        $this->makeJobTitle('Administrative', 'የስትሪፒንግ፣የሪፕሮዳክሽን፣ካሜራና ፕሌት ሜከር ማሽን ኦፕሬተር', 'Level VIII');
        $this->makeJobTitle('Administrative', 'የህትመት ሠራተኛ I', 'Level V');
        $this->makeJobTitle('Administrative', 'የማጠፊያ ማሽን ኦፕሬተር', 'Level VI');
        $this->makeJobTitle('Administrative', 'የመቁረጫ ማሽን ኦፕሬተር', 'Level VI');
        $this->makeJobTitle('Administrative', 'የጥረዛ ሠራተኛ I', 'Level III');
        $this->makeJobTitle('Administrative', 'የኤሌክትሮኒክስ መሳሪያዎች ጥገና ቴክኒሽያን IV', 'Level X');
        $this->makeJobTitle('Administrative', 'የተማሪዎች ሪከርድ ሰራተኛ II', 'Level VII');
        $this->makeJobTitle('Administrative', 'የወርክ ሾፕ ቴክኒሺያን II', 'Level VIII');
        $this->makeJobTitle('Administrative', 'ላብራቶሪ አቴዳንት', 'Level IV');
        $this->makeJobTitle('Administrative', 'የእንጨት ሥራ ቴክኒሸያን I', 'Level VI');
        $this->makeJobTitle('Administrative', 'የቢሮና የመማሪያ ክፍሎች አደራጅ ቁጥጥር ሰራተኛ', 'Level VII');
        $this->makeJobTitle('Administrative', 'የፋይናንስ ቡድን መሪ II', 'Level XIV');
        $this->makeJobTitle('Administrative', 'የሒሳብ ሠራተኛ II', 'Level VIII');
        $this->makeJobTitle('Administrative', 'ረዳት ገንዘብ ያዥ I', 'Level VI');
        $this->makeJobTitle('Administrative', 'አካውንታንት II', 'Level IX');
        $this->makeJobTitle('Administrative', 'የግዥ ቡድን መሪ II', 'Level XIV');
        $this->makeJobTitle('Administrative', 'የግዥ ባለሙያ II', 'Level IX');
        $this->makeJobTitle('Administrative', 'የገበያ ጥናት ባለሙያ II', 'Level IX');
        $this->makeJobTitle('Administrative', 'የውል አስተዳደር ባለሙያ I', 'Level VIII');
        $this->makeJobTitle('Administrative', 'የንብረት ምዝገባና ቁጥጥር ሠራተኛ II', 'Level VII');
        $this->makeJobTitle('Administrative', 'የትራንስፖርት ስምሪት ሠራተኛ III', 'Level VIII');
        $this->makeJobTitle('Administrative', 'ማኔጂንግ ዳይሬክተር', 'Level XVI');
        $this->makeJobTitle('Administrative', 'የንብረት ሥራ አመራር አገልግሎት ኃላፊ I', 'Level XII');
        $this->makeJobTitle('Administrative', 'ረዳት ገንዘብ ያዥ I', 'Level VI');
        $this->makeJobTitle('Administrative', 'ረዳት አንባቢ I', 'Level VII');
        $this->makeJobTitle('Administrative', 'የከብት ጠባቂ (እረኛ)', 'Level III');
        $this->makeJobTitle('Administrative', 'የግዥና ንብረት አስተዳደር ቡድን መሪ II', 'Level XIV');
        $this->makeJobTitle('Administrative', 'ሞተረኛ ፖስተኛ', 'Level IV');
        $this->makeJobTitle('Administrative', 'የሰው ሀብት አስተዳደርና ልማት ቡድን መሪ III', 'Level XV');
        $this->makeJobTitle('Administrative', 'የሰው ሀብት አስተዳደር ባለሙያ III', 'Level XI');
        $this->makeJobTitle('Administrative', 'ትምህርትና  ስልጠና ባለሙያ IV', 'Level XII');
        $this->makeJobTitle('Administrative', 'የትምህርትና ሥልጠና ባለሙያ III', 'Level X');
        $this->makeJobTitle('Administrative', 'የመረጃ ሥራ አመራር ባለሙያ II', 'Level IX');
        $this->makeJobTitle('Administrative', 'የሰው ሀብት አስተዳደር ባለሙያ I', 'Level VIII');
        $this->makeJobTitle('Administrative', 'የግዢ ቡድን መሪ III', 'Level XV');
        $this->makeJobTitle('Administrative', 'የግዥ ባለሙያ III', 'Level XI');
        $this->makeJobTitle('Administrative', 'የውል አስተዳደር ባለሙያ IV', 'Level XIII');
        $this->makeJobTitle('Administrative', 'የውል አስተዳደር ባለሙያ III', 'Level XII');
        $this->makeJobTitle('Administrative', 'የግዢ ባለሙያ IV', 'Level XII');
        $this->makeJobTitle('Administrative', 'የንብረት ስራ አመራር አገልግሎት ኃላፊ III', 'Level XIV');
        $this->makeJobTitle('Administrative', 'የእቃ ግምጃ ቤት ኃላፊ III', 'Level XI');
        $this->makeJobTitle('Administrative', 'የንብረት ምዝገባና ቁጥጥር ሰራተኛ  I', 'Level VI');
        $this->makeJobTitle('Administrative', 'የትራንስፖርት ሥምሪት አገልግሎት ኃላፊ I', 'Level XII');
        $this->makeJobTitle('Administrative', 'አካውንታንት III', 'Level XI');
        $this->makeJobTitle('Administrative', 'ረዳት ገንዘብ ያዥ II', 'Level VII');
        $this->makeJobTitle('Administrative', 'ዋና ገንዘብ ያዥ III', 'Level IX');
        $this->makeJobTitle('Administrative', 'አካውንታንት IV', 'Level XII');
        $this->makeJobTitle('Administrative', 'የአፓርትመንት ሥራዎች ተከታታይ I', 'Level IV');
        $this->makeJobTitle('Administrative', 'የግቢ ውበትና መናፈሻ ሥራዎች ኃላፊ', 'Level XII');
        $this->makeJobTitle('Administrative', 'የግቢ ውበትና መናፈሻ ሠራተኛ I', 'Level VII');
        $this->makeJobTitle('Administrative', 'አትክልተኛ', 'Level III');
        $this->makeJobTitle('Administrative', 'የግቢ ውበትና መናፈሻ ሠራተኛ II', 'Level VIII');
        $this->makeJobTitle('Administrative', 'የጥበቃና ደህንነት አገልግሎት አስተባባሪ', 'Level XII');
        $this->makeJobTitle('Administrative', 'የጥበቃና ደህንነት አገልግሎት ሽፍት ኃላፊ', 'Level VI');
        $this->makeJobTitle('Administrative', 'የካምፓስ ፖሊስ', 'Level IV');
        $this->makeJobTitle('Administrative', 'የጥገና ፎርማን', 'Level X');
        $this->makeJobTitle('Administrative', 'ብረት ብረት ቴክኒሺያን II', 'Level VIII');
        $this->makeJobTitle('Administrative', 'የእንጨት ስራ ቴክኒሽያን IV', 'Level IX');
        $this->makeJobTitle('Administrative', 'የእንጨት ሥራ ቴክኒዪሻያን  II', 'Level VII');
        $this->makeJobTitle('Administrative', 'ቧንቧ ሠራተኛ III', 'Level VIII');
        $this->makeJobTitle('Administrative', 'ቧንቧ ሠራተኛ II', 'Level VII');
        $this->makeJobTitle('Administrative', 'ኤልክትሪክሽያን III', 'Level IX');
        $this->makeJobTitle('Administrative', 'ኤልክትሪክሽያን II', 'Level VIII');
        $this->makeJobTitle('Administrative', 'ኤልክትሪክሽያን I', 'Level VII');
        $this->makeJobTitle('Administrative', 'ብረታ ብረት ቴክኒሺያን III', 'Level IX');
        $this->makeJobTitle('Administrative', 'የውሃ ፓምፕ ኦፕሬተር', 'Level VI');
        $this->makeJobTitle('Administrative', 'ግንበኛ II', 'Level VIII');
        $this->makeJobTitle('Administrative', 'ቀለም ቀቢ II', 'Level VI');
        $this->makeJobTitle('Administrative', 'ጄኔሬተር ኦፕሬተር', 'Level VI');
        $this->makeJobTitle('Administrative', 'የትሪትመንት ኘላንት ኦኘሬሽን ቡድን መሪ', 'Level XV');
        $this->makeJobTitle('Administrative', 'የትሪትመንት ላቦራቶሪ ባለሙያ IV', 'Level XIV');
        $this->makeJobTitle('Administrative', 'አውቶ መካኒክ I', 'Level VII');
        $this->makeJobTitle('Administrative', 'የካፍቴሪያ ሥራ አስኪያጅ', 'Level VIII');
        $this->makeJobTitle('Administrative', 'የተማሪዎች አገልግሎት ጽ/ቤት ኃላፊ', 'Level XV');
        $this->makeJobTitle('Administrative', 'ሳይኮሎጂስት II', 'Level IX');
        $this->makeJobTitle('Administrative', 'የተማሪዎች ጉዳይ ድጋፍና ክትትል ባለሙያ III', 'Level XI');
        $this->makeJobTitle('Administrative', 'የመኝታ ቤት አገልግሎት አስተባባሪ', 'Level X');
        $this->makeJobTitle('Administrative', 'የተማሪዎች መኝታ አገልግሎት ተቆጣጣሪ', 'Level VI');
        $this->makeJobTitle('Administrative', 'የምግብ ዝግጅት አገልግሎት ኃላፊ II', 'Level X');
        $this->makeJobTitle('Administrative', 'የምግብ ዝግጅት አገልግሎት ኃላፊ I', 'Level IX');
        $this->makeJobTitle('Administrative', 'የኤሌክትሮኒክስ መሳሪያዎች ጥገና ቴክኒሽያን II', 'Level VIII');
        $this->makeJobTitle('Administrative', 'የኤሌክትሮኒክስ መሳሪያዎች ጥገና ቴክኒሽያን IV', 'Level X');
        $this->makeJobTitle('Administrative', 'የምግብ ዝግጅት ሠራተኛ III', 'Level V');
        $this->makeJobTitle('Administrative', 'የምግብ ዝግጅት ሠራተኛ II', 'Level IV');
        $this->makeJobTitle('Administrative', 'የምግብ ዝግጅት ሠራተኛ I', 'Level IV');
        $this->makeJobTitle('Administrative', 'ዳቦ ጋጋሪ II', 'Level IV');
        $this->makeJobTitle('Administrative', 'ቲከር', 'Level IV');
        $this->makeJobTitle('Administrative', 'እንጀራ ጋጋሪ II', 'Level IV');
        $this->makeJobTitle('Administrative', 'የልምድ አስተናጋጅ I', 'Level III');
        $this->makeJobTitle('Administrative', 'የወፍጮ ኦፕሬተር II', 'Level IV');
        $this->makeJobTitle('Administrative', 'የህክምና ካርድ ክለርክ', 'Level VII');
        $this->makeJobTitle('Administrative', 'የአምቡላንስ ሹፌር', 'Level VII');
        $this->makeJobTitle('Administrative', 'የህፃናት ሞግዚት', 'Level VI');

        $this->makeJobTitle('Management', 'President', 'Level I');
        $this->makeJobTitle('Management', 'Vice President', 'Level I');

        $this->makeJobTitle('Technical', 'Technical Support', 'Level I');
    }

    /**
     * @param $staff_type
     * @param $title
     * @param $level
     */
    private function makeJobTitle($staff_type, $title, $level = 'Level I')
    {
        $job_title = new JobTitle();
        $job_title->staff_type = $staff_type;
        $job_title->job_title = $title;
        $job_title->level = $level;
        $job_title->save();
    }
}
