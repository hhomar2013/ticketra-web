<?php
namespace App\Exports;


use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;

class AssetsTemplateExport implements FromCollection, WithHeadings, WithEvents
{
    protected $branches;
    protected $categories;
    protected $brandsWithModels;

    public function __construct($branches, $categories, $brandsWithModels)
    {
        $this->branches = $branches;
        $this->categories = $categories;
        $this->brandsWithModels = $brandsWithModels;
    }

    /**
     * الـ Collection هنا هترجع الشيت الأساسي فاضي للمستخدم 
     * جاهز بس إنه يعبي فيه الداتا (مثلاً بنسيب سطر واحد تجريبي أو فاضي)
     */
    public function collection()
    {
        return new Collection([
            // سطر تجريبي يوضح للمستخدم شكل البيانات (اختياري)
            ['Example-Tag-001', '', '', '', '']
        ]);
    }

    /**
     * عناوين الأعمدة الرئيسية في شيت الـ Entry
     */
    public function headings(): array
    {
        return [
            'Asset Tag',
            'Branch',
            'Category',
            'Brand',
            'Model Type'
        ];
    }

    /**
     * الـ Events لتجهيز القوائم المنسدلة والديناميكية
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $spreadsheet = $event->sheet->getDelegate()->getParent();

                // إنشاء ورقة العمل المخفية وحقن بيانات الـ DB
                $lookupSheet = $spreadsheet->createSheet();
                $lookupSheet->setTitle('Data_Lookups');

                // كتابة الفروع في العمود A
                $lookupSheet->setCellValue('A1', 'Branches');
                foreach ($this->branches as $index => $branch) {
                    $lookupSheet->setCellValue('A' . ($index + 2), $branch);
                }

                // كتابة التصنيفات في العمود B
                $lookupSheet->setCellValue('B1', 'Categories');
                foreach ($this->categories as $index => $cat) {
                    $lookupSheet->setCellValue('B' . ($index + 2), $cat);
                }

                // كتابة البراندات والموديلات بشكل أفقي ورأسي تبدأ من العمود D
                $colLetter = 'D';
                foreach ($this->brandsWithModels as $brandName => $models) {
                    $lookupSheet->setCellValue($colLetter . '1', $brandName);
                    foreach ($models as $mIndex => $modelName) {
                        $lookupSheet->setCellValue($colLetter . ($mIndex + 2), $modelName);
                    }
                    $colLetter++;
                }

                // إخفاء ورقة البيانات
                $lookupSheet->setSheetState(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::SHEETSTATE_HIDDEN);

                // تطبيق الـ Data Validation على ورقة الإدخال الرئيسية
                $mainSheet = $spreadsheet->getSheet(0);

                for ($i = 2; $i <= 1000; $i++) {
                    // Dropdown الفروع (العمود B)
                    $validationBranch = $mainSheet->getCell("B$i")->getDataValidation();
                    $validationBranch->setType(DataValidation::TYPE_LIST)->setFormula1('Data_Lookups!$A$2:$A$100')->setShowDropDown(true);

                    // Dropdown التصنيفات (العمود C)
                    $validationCat = $mainSheet->getCell("C$i")->getDataValidation();
                    $validationCat->setType(DataValidation::TYPE_LIST)->setFormula1('Data_Lookups!$B$2:$B$100')->setShowDropDown(true);

                    // Dropdown الموديل الديناميكي (العمود E) المعتمد على البراند في (العمود D)
                    $validationModel = $mainSheet->getCell("E$i")->getDataValidation();
                    $validationModel->setType(DataValidation::TYPE_LIST)
                        ->setFormula1("=OFFSET(Data_Lookups!\$D\$2, 0, MATCH(D$i, Data_Lookups!\$D\$1:\$Z\$1, 0)-1, COUNTA(OFFSET(Data_Lookups!\$D\$2, 0, MATCH(D$i, Data_Lookups!\$D\$1:\$Z\$1, 0)-1, 100, 1)), 1)")
                        ->setShowDropDown(true);
                }
            },
        ];
    }
}