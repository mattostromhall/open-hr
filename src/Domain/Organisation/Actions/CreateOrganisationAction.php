<?php

namespace Domain\Organisation\Actions;

use Domain\Files\Actions\Contracts\StoreFileActionInterface;
use Domain\Files\DataTransferObjects\UploadedFileData;
use Domain\Organisation\Actions\Contracts\CreateOrganisationActionInterface;
use Domain\Organisation\DataTransferObjects\OrganisationData;
use Domain\Organisation\Models\Organisation;
use Illuminate\Http\UploadedFile;

class CreateOrganisationAction implements CreateOrganisationActionInterface
{
    public function __construct(protected StoreFileActionInterface $storeFile)
    {
        //
    }

    public function execute(OrganisationData $data): Organisation
    {
        $logo = $this->handleLogoUpload($data->logo);

        return Organisation::create([
            'name' => $data->name,
            'logo' => $logo,
            'setup_at' => $data->setup_at
        ]);
    }

    protected function handleLogoUpload(UploadedFile|string $file): bool|string
    {
        if (is_string($file)) {
            return $file;
        }

        $uploadedFileData = new UploadedFileData(
            file: $file,
            path: 'public/images',
            name: 'logo'
        );

        return $this->storeFile->execute($uploadedFileData);
    }
}
