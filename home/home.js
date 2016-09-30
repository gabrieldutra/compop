(function(){
    angular.module('compOp')
    .controller('homeCtrl',homeCtrl);
    function homeCtrl(timeAgo){
        var vm = this;
        vm.oportunities = [
                    {
                        "id": "4",
                        "creator_id": "1",
                        "title": "Estágio DECOM",
                        "approved": "1",
                        "status": "0",
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec fermentum eu est non porta. Maecenas ex ante, auctor quis tortor at, ornare rhoncus enim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum ultrices rutrum quam vitae faucibus. Aenean condimentum lorem ex. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec nisi nisl, efficitur at euismod et, facilisis et est. Morbi porttitor tortor vitae sapien sodales, eget ultrices metus tempor. Morbi tellus massa, aliquet sit amet vestibulum quis, vulputate viverra lorem. In suscipit diam vitae neque euismod, vitae egestas lacus fringilla. Etiam luctus velit dolor, eget varius sem commodo eu. Nulla sapien sem, posuere et est quis, ultricies consequat elit. Fusce ac rutrum magna. Nunc rutrum tempor consectetur. Cras ut magna in ante commodo sagittis gravida vel nisi. Integer rutrum posuere quam.",
                        "inscription": "Donec ex dolor, facilisis et urna a, tincidunt venenatis lorem. Duis consectetur purus mollis arcu aliquet, sit amet venenatis nisl ultrices. Fusce luctus aliquet ipsum sit amet vestibulum. Sed a magna ut justo bibendum rhoncus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Ut est ex, sollicitudin sed leo ut, egestas tristique neque. Phasellus tristique sapien eget lectus luctus malesuada. Nunc est ligula, bibendum id bibendum vel, ultrices vel justo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras in sodales odio. Morbi pharetra pellentesque congue. Suspendisse nec fermentum ex, sed efficitur leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.",
                        "photo": "http://www.sdsmt.edu/uploadedImages/Content/Academics/Degrees/_Images/DegCompEngBanner.jpg",
                        "created": "2016-09-27 10:26:28",
                        "updated": "2016-09-27 11:47:26",
                        "creator": {
                        "id": "1",
                        "name": "Gabriel Dutra",
                        "about": "Teste de update"
                        }
                    },
                    {
                        "id": "4",
                        "creator_id": "1",
                        "title": "IC para o descritores para reconhecimento de ações humanas denov",
                        "approved": "1",
                        "status": "0",
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec fermentum eu est non porta. Maecenas ex ante, auctor quis tortor at, ornare rhoncus enim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum ultrices rutrum quam vitae faucibus. Aenean condimentum lorem ex. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec nisi nisl, efficitur at euismod et, facilisis et est. Morbi porttitor tortor vitae sapien sodales, eget ultrices metus tempor. Morbi tellus massa, aliquet sit amet vestibulum quis, vulputate viverra lorem. In suscipit diam vitae neque euismod, vitae egestas lacus fringilla. Etiam luctus velit dolor, eget varius sem commodo eu. Nulla sapien sem, posuere et est quis, ultricies consequat elit. Fusce ac rutrum magna. Nunc rutrum tempor consectetur. Cras ut magna in ante commodo sagittis gravida vel nisi. Integer rutrum posuere quam.",
                        "inscription": "Donec ex dolor, facilisis et urna a, tincidunt venenatis lorem. Duis consectetur purus mollis arcu aliquet, sit amet venenatis nisl ultrices. Fusce luctus aliquet ipsum sit amet vestibulum. Sed a magna ut justo bibendum rhoncus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Ut est ex, sollicitudin sed leo ut, egestas tristique neque. Phasellus tristique sapien eget lectus luctus malesuada. Nunc est ligula, bibendum id bibendum vel, ultrices vel justo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras in sodales odio. Morbi pharetra pellentesque congue. Suspendisse nec fermentum ex, sed efficitur leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.",
                        "photo": "https://ece.njit.edu/sites/ece/files/lcms/images/ms-computer-engineering-2010.jpg",
                        "created": "2016-09-27 10:26:28",
                        "updated": "2016-09-27 11:47:26",
                        "creator": {
                        "id": "1",
                        "name": "Gabriel Dutra",
                        "about": "Teste de update"
                        }
                    },
                    {
                        "id": "4",
                        "creator_id": "1",
                        "title": "Complete oportunity2",
                        "approved": "1",
                        "status": "0",
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec fermentum eu est non porta. Maecenas ex ante, auctor quis tortor at, ornare rhoncus enim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum ultrices rutrum quam vitae faucibus. Aenean condimentum lorem ex. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec nisi nisl, efficitur at euismod et, facilisis et est. Morbi porttitor tortor vitae sapien sodales, eget ultrices metus tempor. Morbi tellus massa, aliquet sit amet vestibulum quis, vulputate viverra lorem. In suscipit diam vitae neque euismod, vitae egestas lacus fringilla. Etiam luctus velit dolor, eget varius sem commodo eu. Nulla sapien sem, posuere et est quis, ultricies consequat elit. Fusce ac rutrum magna. Nunc rutrum tempor consectetur. Cras ut magna in ante commodo sagittis gravida vel nisi. Integer rutrum posuere quam.",
                        "inscription": "Donec ex dolor, facilisis et urna a, tincidunt venenatis lorem. Duis consectetur purus mollis arcu aliquet, sit amet venenatis nisl ultrices. Fusce luctus aliquet ipsum sit amet vestibulum. Sed a magna ut justo bibendum rhoncus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Ut est ex, sollicitudin sed leo ut, egestas tristique neque. Phasellus tristique sapien eget lectus luctus malesuada. Nunc est ligula, bibendum id bibendum vel, ultrices vel justo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras in sodales odio. Morbi pharetra pellentesque congue. Suspendisse nec fermentum ex, sed efficitur leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.",
                        "photo": "http://www.diskfone.com.br/appDiskFone/assets/image/sem_logo.png",
                        "created": "2016-09-27 10:26:28",
                        "updated": "2016-09-27 11:47:26",
                        "creator": {
                        "id": "1",
                        "name": "Gabriel Dutra",
                        "about": "Teste de update"
                        }
                    }                    
                ];
        vm.loading = false;
    }
}())