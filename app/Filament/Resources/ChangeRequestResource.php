<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChangeRequestResource\Pages;
use App\Filament\Resources\ChangeRequestResource\RelationManagers;
use App\Models\ChangeRequest;
use App\Filament\Resources\ChangeRequestResource\Actions\ApproveAction;
use Auth;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ChangeRequestResource extends Resource
{
    protected static ?string $model = ChangeRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    private static function calculateRiskValues($state, $set, $get): void
    {
        $severityMap = ['minor' => 1, 'major' => 3, 'critical' => 5];
        $probabilityMap = ['rare' => 1, 'possible' => 3, 'frequent' => 5];
        $detectabilityMap = ['high' => 1, 'medium' => 3, 'low' => 5];

        $severity = $severityMap[$get('risk_evaluation_criteria_severity')] ?? 1;
        $probability = $probabilityMap[$get('risk_evaluation_criteria_probability')] ?? 1;
        $detectability = $detectabilityMap[$get('risk_evaluation_criteria_detectability')] ?? 1;

        $riskPriorityNumber = $severity * $probability * $detectability;
        $set('risk_priority_number', $riskPriorityNumber);
        $set('risk_category', $riskPriorityNumber >= 45 ? 'Kritikal' : ($riskPriorityNumber >= 15 ? 'Mayor' : 'Minor'));
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dasar / Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('created_at')
                            ->default(now())
                            ->label('Tanggal / Date')
                            ->formatStateUsing(fn($state) => Carbon::parse($state)->format('l, d F Y'))
                            ->readOnly()
                            ->required(),
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Perubahan / Tittle Of Change')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('user_id')
                            ->default(Auth::id())
                            ->label('Nama Inisiator / Initiator Name')
                            ->formatStateUsing(fn($state) => \App\Models\User::find($state)?->name ?? '')
                            ->readOnly()
                            ->required(),
                        Forms\Components\TextInput::make('department_id')
                            ->default(Auth::user()->department_id)
                            ->label('Departemen Inisiator / Initiator Department')
                            ->readOnly()
                            ->formatStateUsing(fn($state) => \App\Models\Department::find($state)?->name ?? '')
                            ->required(),
                        Forms\Components\CheckboxList::make('scope_of_change')
                            ->label('Cakupan Perubahan / Scope Of Change')
                            ->relationship('scope_of_changes', 'id')
                            ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->value}")
                            ->required(),
                        Forms\Components\CheckboxList::make('stimuli_of_change')
                            ->label('Stimuli Perubahan / Stimuli Of Change')
                            ->relationship('stimuli_of_changes', 'id')
                            ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->value}")
                            ->required(),
                    ]),
                Forms\Components\Section::make('Deskripsi Perubahan / Description Of Change')
                    ->schema([
                        Forms\Components\TextInput::make('current_status')
                            ->label('Status Saat ini / Current Status')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('current_status_url')
                            ->label('File Status Saat ini / Current Status File')
                            ->disk('public')
                            ->getUploadedFileNameForStorageUsing(
                                fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                    ->prepend(
                                        now()->format('YmdHis')
                                    ),
                            )
                            ->visibility('public')
                            ->directory('change_request_status')
                            ->multiple()
                            ->openable()
                            ->downloadable()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('change_request')
                            ->label('Usuluan Perubahan / Change Request')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('change_request_url')
                            ->label('Link Usuluan Perubahan / Change Request URL')
                            ->disk('public')
                            ->getUploadedFileNameForStorageUsing(
                                fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                    ->prepend(
                                        now()->format('YmdHis')
                                    ),
                            )
                            ->visibility('public')
                            ->directory('change_request')
                            ->multiple()
                            ->openable()
                            ->downloadable()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('reason')
                            ->label('Alasan Perubahan / Reason Of Change')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('support_document_url')
                            ->label('Lampiran Data Pendukung / Supporting data attachment')
                            ->disk('public')
                            ->getUploadedFileNameForStorageUsing(
                                fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                    ->prepend(
                                        now()->format('YmdHis')
                                    ),
                            )
                            ->visibility('public')
                            ->directory('change_request_support_document')
                            ->multiple()
                            ->openable()
                            ->downloadable()
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('Kajian Terhadap Dampak-Risiko / Impact-Risk Assesment')
                    ->schema([
                        Forms\Components\TextInput::make('source_of_risk')
                            ->label('Sumber Resiko / Source Of Risk')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('impact_of_risk')
                            ->label('Dampak Resiko / Impact of Risks')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Radio::make('risk_evaluation_criteria_severity')
                            ->label('Kriteria Penilaian Resiko - Saverity / Risk Evaluation Criteria - Severity')
                            ->options([
                                'minor' => 'Minor (1)',
                                'major' => 'Mayor (3)',
                                'critical' => 'Kritikal (5)'
                            ])
                            ->required()
                            ->live()
                            ->default('minor')
                            ->afterStateUpdated(fn($state, $set, $get) => self::calculateRiskValues($state, $set, $get)),
                        Forms\Components\TextInput::make('causes_of_risk')
                            ->label('Penyebab Resiko / Causes of Risk')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Radio::make('risk_evaluation_criteria_probability')
                            ->label('Kriteria Penilaian Resiko - Probability / Risk Evaluation Criteria - Probability')
                            ->options([
                                'rare' => 'Jarang (1)',
                                'possible' => 'Mungkin Terjadi (3)',
                                'frequent' => 'Sering (5)'
                            ])
                            ->required()
                            ->live()
                            ->default('rare')
                            ->afterStateUpdated(fn($state, $set, $get) => self::calculateRiskValues($state, $set, $get)),
                        Forms\Components\TextInput::make('control_that_has_been_implemented')
                            ->label('Kontrol Yang Telah Dilakukan / Control that has been implemented')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Radio::make('risk_evaluation_criteria_detectability')
                            ->label('Kriteria Penilaian Resiko - Detectability / Risk Evaluation Criteria - Detectability')
                            ->options([
                                'high' => 'Tinggi (1)',
                                'medium' => 'Sedang (3)',
                                'low' => 'Rendah (5)'
                            ])
                            ->required()
                            ->live()
                            ->default('high')
                            ->afterStateUpdated(fn($state, $set, $get) => self::calculateRiskValues($state, $set, $get)),
                        Forms\Components\TextInput::make('risk_priority_number')
                            ->label('Risk Priority Number (RPN)')
                            ->required()
                            ->numeric()
                            ->readOnly()
                            ->dehydrated(),
                        Forms\Components\TextInput::make('risk_category')
                            ->label('Kategori Resiko / Risk Category')
                            ->required()
                            ->readOnly()
                            ->dehydrated()
                    ]),
                Forms\Components\Section::make('Perizinan Perubahan Fasilitas / Facility Change Authorization')
                    ->schema([
                        Forms\Components\Radio::make('facility_change_authorization_id')
                            ->label('Perizinan Perubahan Fasilitas / Facility Change Authorization')
                            ->options(function () {
                                return \App\Models\FacilityChangeAuthorization::pluck('value', 'id');
                            })
                            ->required(),
                    ]),
                Forms\Components\Section::make('Kajian Terkait Regulatory / Regulatory Assesment')
                    ->schema([
                        Forms\Components\Radio::make('regulatory_assesment_id')
                            ->label('Kategori Pelaporan Registrasi / Reporting Categories for Registration')
                            ->options(function () {
                                return \App\Models\RegulatoryAssesment::pluck('value', 'id');
                            })
                            ->required(),
                    ]),
                Forms\Components\Section::make('Kajian Terkait Halal / Halal Assesment')
                    ->schema([
                        Forms\Components\Radio::make('halal_assesment_id')
                            ->label('Apakah Material atau Kegiatan digunakan terkait produk /  Are materials or activities involved in Halal products')
                            ->options(function () {
                                return \App\Models\HalalAssesment::pluck('value', 'id');
                            })
                            ->required(),
                    ]),
                Forms\Components\Section::make('Kajian Terkait Pihak Ketiga / Assessment related to Third Parties')
                    ->schema([
                        Forms\Components\Radio::make('is_third_party_name')
                            ->label('Apakah perubahan akan diinformasikan ke pihak Toll Manufacturing ? / Will the changes be communicated to the Toll Manufacturing ?')
                            ->options([
                                'ya' => 'Ya',
                                'tidak' => 'Tidak',
                            ])
                            ->afterStateHydrated(function ($component, $state, $get) {
                                if (!filled($state)) {
                                    $third_party_name = $get('third_party_name');
                                    if ($third_party_name) {
                                        $component->state(['ya']);
                                    } else {
                                        $component->state(['tidak']);
                                    }
                                }
                            })
                            ->live()
                            ->required(),
                        Forms\Components\TextInput::make('third_party_name')
                            ->label('Nama Pihak Ketiga / Third Party Name')
                            ->hidden(fn($get): bool => $get('is_third_party_name') != 'ya')
                            ->required()
                            ->maxLength(255),
                    ]),

                Forms\Components\Section::make('Departemen Lain yang Terkait Dalam Usulan Perubahan / The Other Departement That Related to Change Control')
                    ->schema([
                        Forms\Components\CheckboxList::make('departments')
                            ->label('Departemen Lain yang Terkait Dalam Usulan Perubahan / The Other Departement That Related to Change Control')
                            ->relationship('departments', 'id')
                            ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->name}")
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->label('Judul'),
                Tables\Columns\TextColumn::make('user_id')
                    ->label('Nama ')
                    ->sortable()
                    ->formatStateUsing(fn($state) => \App\Models\User::find($state)?->name ?? ''),
                Tables\Columns\TextColumn::make('department_id')
                    ->label('Departemen')
                    ->formatStateUsing(fn($state) => \App\Models\Department::find($state)?->name ?? '')
                    ->sortable(),
                Tables\Columns\TextColumn::make('current_status')
                    ->searchable()
                    ->label('Status'),
                Tables\Columns\TextColumn::make('current_status_url')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('File Status'),
                Tables\Columns\TextColumn::make('change_request_url')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Link Usulan Perubahan'),
                Tables\Columns\TextColumn::make('support_document_url')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Lampiran Data Pendukung'),
                Tables\Columns\TextColumn::make('source_of_risk')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->label('Sumber Resiko'),
                Tables\Columns\TextColumn::make('impact_of_risk')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->label('Dampak Resiko'),
                Tables\Columns\TextColumn::make('risk_evaluation_criteria_severity')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->label('Kriteria Penilaian Resiko - Saverity'),
                Tables\Columns\TextColumn::make('causes_of_risk')
                    ->searchable()
                    ->label('Penyebab Resiko'),
                Tables\Columns\TextColumn::make('risk_evaluation_criteria_probability')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Kriteria Penilaian Resiko - Probability'),
                Tables\Columns\TextColumn::make('control_that_has_been_implemented')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Kontrol Yang Telah Dilakukan'),
                Tables\Columns\TextColumn::make('risk_evaluation_criteria_detectability')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Kriteria Penilaian Resiko - Detectability'),
                Tables\Columns\TextColumn::make('risk_priority_number')
                    ->numeric()
                    ->sortable()
                    ->label('RPN'),
                Tables\Columns\TextColumn::make('risk_category')
                    ->searchable()
                    ->label('Kategori Resiko'),
                Tables\Columns\TextColumn::make('facility_change_authorization_id')
                    ->numeric()
                    ->sortable()
                    ->label('Perizinan Perubahan Fasilitas')
                    ->formatStateUsing(fn($state) => \App\Models\FacilityChangeAuthorization::find($state)?->value ?? '')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('regulatory_assesment_id')
                    ->numeric()
                    ->sortable()
                    ->label('Kategori Pelaporan Registrasi')
                    ->formatStateUsing(fn($state) => \App\Models\RegulatoryAssesment::find($state)?->value ?? '')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('halal_assesment_id')
                    ->numeric()
                    ->sortable()
                    ->label('Apakah Material atau Kegiatan digunakan terkait produk')
                    ->formatStateUsing(fn($state) => \App\Models\HalalAssesment::find($state)?->value ?? '')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('third_party_name')
                    ->searchable()
                    ->label('Nama Pihak Ketiga')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('scope_of_change')
                    ->label('Cakupan Perubahan')
                    ->relationship('scope_of_changes', 'value'),
                SelectFilter::make('department_id')
                    ->label('Departemen')
                    ->relationship('departments', 'name'),
                SelectFilter::make('risk_category')
                    ->label('Kategori Resiko')
                    ->options([
                        'Kritikal' => 'Kritikal',
                        'Mayor' => 'Mayor',
                        'Minor' => 'Minor',
                    ]),

            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                ApproveAction::tableAction(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChangeRequests::route('/'),
            'create' => Pages\CreateChangeRequest::route('/create'),
            'view' => Pages\ViewChangeRequest::route('/{record}'),
            'edit' => Pages\EditChangeRequest::route('/{record}/edit'),
        ];
    }
}
