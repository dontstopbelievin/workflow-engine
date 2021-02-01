<?php

use Illuminate\Database\Seeder;
use App\Process;
use App\CreatedTable;

class ProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    use App\Traits\dbQueries;
    public function run()
    {
        DB::table('processes')->insert([
            [
                'deadline' => 12,
                'name' => 'Утверждение землеустроительных проектов по формированию земельных участков',//1,
            ],
            [
                'deadline' => 12,
                'name' => 'Предоставление исходных материалов при разработке проектов строительства и реконструкции' //2
            ],
            [
                'deadline' => 15,
                'name' => 'Согласование эскизного проекта' //3
            ],
            [
                'deadline' => 8,
                'name' => 'Выдача выписки об учетной записи договора о долевом участии в жилищном строительства' //4
            ],
            [
                'deadline' => 9,
                'name' => ' Выдача решения на изменение целевого назначения земельного участка' //5
            ],
            [
                'deadline' => 11,
                'name' => ' Выдача разрешения на использование земельного участка для изыскательских работ' //6
            ],
            [
                'deadline' => 12,
                'name' => 'Приобретение прав на земельные участки которые находятся в государственной собственности не требующее проведения торгов' //7
            ],
            [
                'deadline' => 8,
                'name' => 'Определение делимости и неделимости земельных участков' //8
            ],
            [
                'deadline' => 12,
                'name' => ' Предоставление земельного участка для строительства объекта в черте населенного пункта' //9
            ],
            [
                'deadline' => 14,
                'name' => 'Выдача разрешения на привлечение денег дольщиков' //10
            ],
            [
                'deadline' =>11,
                'name' => 'Продажа земельного участка в частную собственность единовременно либо в рассрочку' //11
            ],
            [
                'deadline' => 11,
                'name' => 'Заключение договоров купли-продажи земельного участка' //12
            ],
            [
                'deadline' => 8,
                'name' => 'Заключение договоров аренды земельного участка' //13
            ],
            [
                'deadline' => 12,
                'name' => 'Постановка на очередь на получение земельного участка' //14
            ],
            [
                'deadline' => 14,
                'name' => 'Выдача решения на проведение комплекса работ по постутилизации объектов' //15
            ],
            
        ]);

        $processes = Process::all();
        $fields = ['name', 'surname', 'address', 'attachment'];
        foreach ($processes as $process) {
            $this->createProcessTable($fields, $process);
        }
    }

    public function createProcessTable($fields, Process $process) {
        try {
            DB::beginTransaction();
            $processName = $process->name;
            $tableName = $this->translateSybmols($processName);
            $tableName = $this->checkForWrongCharacters($tableName);
            if (strlen($tableName) > 60) {
                $tableName = $this->truncateTableName($tableName); // если количество символов больше 64, то необходимо укоротить длину названия до 64
            }
            $tableName = $this->modifyTableName($tableName);
            $table = new CreatedTable();
            $table->name = $tableName;
            $table->save();
            if (!Schema::hasTable($tableName)) {
                $dbQueryString = "CREATE TABLE $tableName (id INT PRIMARY KEY AUTO_INCREMENT)";
                DB::statement($dbQueryString);
            }
            foreach($fields as $fieldName) {
                if($this->isRussian($fieldName)) {
                    $fieldName = $this->translateSybmols($fieldName);
                } ;
                $fieldName = $this->checkForWrongCharacters($fieldName);
                if (Schema::hasColumn($tableName, $fieldName)) {
                    continue;
                } else {
                    $dbQueryString = "ALTER TABLE $tableName ADD COLUMN $fieldName varchar(255)";
                    DB::statement($dbQueryString);
                }
            }
            if (!Schema::hasColumn($tableName, 'process_id')) {
                $dbQueryString = "ALTER TABLE $tableName ADD  process_id INT";
                DB::statement($dbQueryString);
                DB::table($tableName)->insert(
                    [ 'process_id' => $process->id ]
                );
            }

            if (!Schema::hasColumn($tableName, 'status_id')) {
                $dbQueryString = "ALTER TABLE $tableName ADD  status_id INT";
                DB::statement($dbQueryString);
            }
            if (!Schema::hasColumn($tableName, 'to_revision')) {
                $dbQueryString = "ALTER TABLE $tableName ADD  to_revision BIT";
                DB::statement($dbQueryString);
            }
            if (!Schema::hasColumn($tableName, 'user_id')) {
                $dbQueryString = "ALTER TABLE $tableName ADD  user_id INT";
                DB::statement($dbQueryString);
            }
            if (!Schema::hasColumn($tableName, 'index_sub_route')) {
                $dbQueryString = "ALTER TABLE $tableName ADD  index_sub_route INT";
                DB::statement($dbQueryString);
            }
            if (!Schema::hasColumn($tableName, 'index_main')) {
                $dbQueryString = "ALTER TABLE $tableName ADD index_main INT";
                DB::statement($dbQueryString);
            }
            if (!Schema::hasColumn($tableName, 'doc_path')) {
                $dbQueryString = "ALTER TABLE $tableName ADD doc_path varchar(255)";
                DB::statement($dbQueryString);
            }
            if (!Schema::hasColumn($tableName, 'reject_reason')) {
                $dbQueryString = "ALTER TABLE $tableName ADD reject_reason varchar(255)";
                DB::statement($dbQueryString);
            }
            if (!Schema::hasColumn($tableName, 'reject_reason_from_spec_id')) {
                $dbQueryString = "ALTER TABLE $tableName ADD reject_reason_from_spec_id varchar(255)";
                DB::statement($dbQueryString);
            }
            if (!Schema::hasColumn($tableName, 'revision_reason')) {
                $dbQueryString = "ALTER TABLE $tableName ADD revision_reason varchar(255)";
                DB::statement($dbQueryString);
            }
            if (!Schema::hasColumn($tableName, 'revision_reason_from_spec_id')) {
                $dbQueryString = "ALTER TABLE $tableName ADD revision_reason_from_spec_id varchar(255)";
                DB::statement($dbQueryString);
            }
            if (!Schema::hasColumn($tableName, 'revision_reason_to_spec_id')) {
                $dbQueryString = "ALTER TABLE $tableName ADD revision_reason_to_spec_id varchar(255)";
                DB::statement($dbQueryString);
            }
            $dbQueryString = "ALTER TABLE $tableName ADD updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ";
            DB::statement($dbQueryString);
            DB::commit();
            return Redirect::route('processes.edit', [$process])->with('status', 'Таблица успешно создана');
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
