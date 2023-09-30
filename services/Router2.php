<?php

class Router2
{
    private UserController $userController;
    private PageController $pageController;
    private FileController $fileController;
    private AuthenticationController $authenticationController;
    private StaticPageController $staticPageController;
    private AdminController $adminController;
    private PostController $postController;

    public function __construct()
    {
        $this->userController = new UserController();
        $this->pageController = new PageController();
        $this->fileController = new FileController();
        $this->authenticationController = new AuthenticationController();
        $this->staticPageController = new StaticPageController();
        $this->adminController = new AdminController();
        $this->postController = new PostController();
    }

    private function splitRouteAndParameters(string $route): array
    {
        $routeAndParams = [];
        $routeAndParams['route'] = null;
        $routeAndParams['subRoute'] = null;
        $routeAndParams['subSubRoute'] = null;
        $routeAndParams['admin'] = null;
        $routeAndParams['familySpace'] = null;
        $routeAndParams['authentication'] = null;
        $routeAndParams['action'] = null;

        $routeAndParams['user'] = null;
        $routeAndParams['child'] = null;
        $routeAndParams['week'] = null;

        $routeAndParams['councilReportSlug'] = null;
        $routeAndParams['bulletinSlug'] = null;
        $routeAndParams['projectSlug'] = null;
        $routeAndParams['postSlug'] = null;
        $routeAndParams['associationSlug'] = null;
        $routeAndParams['locationSlug'] = null;
        $routeAndParams['localProfessionalSlug'] = null;

        if (strlen($route) > 0) {
            $tab = explode("/", $route);
            var_dump($tab);

            //PUBLIC
            if ($tab[0] === 'mairie') {
                $routeAndParams['route'] = $tab[0];

                if (isset($tab[1])) {
                    if ($tab[1] === 'conseil-municipal') {
                        $routeAndParams['subRoute'] = $tab[1];

                        if (isset($tab[2])) {
                            if ($tab[2] === 'comptes-rendus-conseil-municipaux') {
                                $routeAndParams['subSubRoute'] = $tab[2];

                                if (isset($tab[3])) {
                                    $routeAndParams['councilReportSlug'] = $tab[3];
                                }
                            } else if ($tab[2] === 'bulletins-municipaux') {
                                $routeAndParams['subSubRoute'] = $tab[2];

                                if (isset($tab[3])) {
                                    $routeAndParams['bulletinSlug'] = $tab[3];
                                }
                            } else if ($tab[2] === 'elus') {
                                $routeAndParams['subSubRoute'] = $tab[2];
                            } else if ($tab[2] === 'plu') {
                                $routeAndParams['subSubRoute'] = $tab[2];
                            }
                        }
                    } else if ($tab[1] === 'services-municipaux') {
                        $routeAndParams['subRoute'] = $tab[1];

                        if (isset($tab[2])) {
                            if ($tab[2] === 'recensement') {
                                $routeAndParams['subSubRoute'] = $tab[2];
                            } else if ($tab[2] === 'papiers-identite') {
                                $routeAndParams['subSubRoute'] = $tab[2];
                            } else if ($tab[2] === 'location-salle') {
                                $routeAndParams['subSubRoute'] = $tab[2];
                            }
                        }
                    }
                }
            } else if ($tab[0] === 'projets') {
                $routeAndParams['route'] = $tab[0];

                if (isset($tab[1])) {
                    $routeAndParams['projectSlug'] = $tab[1];
                }
            } else if ($tab[0] === 'pratique') {
                $routeAndParams['route'] = $tab[0];

                if (isset($tab[1])) {
                    $routeAndParams['postSlug'] = $tab[1];
                }
            } else if ($tab[0] === 'vivre') {
                $routeAndParams['route'] = $tab[0];

                if (isset($tab[1])) {
                    $routeAndParams['postSlug'] = $tab[1];
                }
            } else if ($tab[0] === 'decouvrir') {
                $routeAndParams['route'] = $tab[0];

                if (isset($tab[1])) {
                    $routeAndParams['postSlug'] = $tab[1];
                }
            } else if ($tab[0] === 'mentions-legales') {
                $routeAndParams['route'] = $tab[0];
            } else if ($tab[0] === 'politique-confidentialite') {
                $routeAndParams['route'] = $tab[0];
            }

            //AUTHENTICATION
            else if ($tab[0] === 'authentification') {
                $routeAndParams['route'] = $tab[0];

                if (isset($tab[1])) {
                    if ($tab[1] === 'se-connecter') {
                        $routeAndParams['authentication'] = $tab[1];
                    } else if ($tab[1] === 'se-deconnecter') {
                        $routeAndParams['authentication'] = $tab[1];
                    } else if ($tab[1] === 'enregistrer-nouveau-compte') {
                        $routeAndParams['authentication'] = $tab[1];
                    }
                }
            }

            //ADMIN
            else if ($tab[0] === 'admin') {
                $routeAndParams['route'] = 'admin';

                if (isset($tab[1])) {
                    if ($tab[1] === 'modifier-email') {
                        $routeAndParams['admin'] = $tab[1];
                    } else if ($tab[1] === 'ajouter-un-fichier') {
                        $routeAndParams['admin'] = $tab[1];
                    } else if ($tab[1] === 'bulletins-municipaux') {
                        $routeAndParams['admin'] = $tab[1];

                        if (isset($tab[2])) {
                            $routeAndParams['bulletinSlug'] = $tab[2];
                        }
                    } else if ($tab[1] === 'comptes-rendus-conseils-municipaux') {
                        $routeAndParams['admin'] = $tab[1];

                        if (isset($tab[2])) {
                            $routeAndParams['councilReportSlug'] = $tab[2];
                        }
                    } else if ($tab[1] === 'informations-locales') {
                        $routeAndParams['admin'] = $tab[1];

                        if (isset($tab[2])) {
                            if ($tab[2] === 'associations') {
                                $routeAndParams['subRoute'] = $tab[2];

                                if (isset($tab[3])) {
                                    if ($tab[3] === 'ajouter') {
                                        $routeAndParams['route'] = $tab[3];
                                    } else if ($tab[3] === 'modifier') {
                                        $routeAndParams['route'] = $tab[3];
                                        $routeAndParams['associationSlug'] = $tab[4];
                                    }
                                }
                            } else if ($tab[2] === 'lieux') {
                                $routeAndParams['subRoute'] = $tab[2];

                                if (isset($tab[3])) {
                                    if ($tab[3] === 'ajouter') {
                                        $routeAndParams['route'] = $tab[3];
                                    } else if ($tab[3] === 'modifier') {
                                        $routeAndParams['route'] = $tab[3];
                                        $routeAndParams['locationSlug'] = $tab[4];
                                    }
                                }
                            } else if ($tab[2] === 'professionnels-locaux') {
                                $routeAndParams['subRoute'] = $tab[2];

                                if (isset($tab[3])) {
                                    if ($tab[3] === 'ajouter') {
                                        $routeAndParams['route'] = $tab[3];
                                    } else if ($tab[3] === 'modifier') {
                                        $routeAndParams['route'] = $tab[3];
                                        $routeAndParams['localProfessionalSlug'] = $tab[4];
                                    }
                                }
                            }
                        }
                    } else if ($tab[1] === 'evenements') {
                        $routeAndParams['admin'] = $tab[1];

                        if(isset($tab[2])) {
                            if ($tab[2] === 'ajouter') {
                                $routeAndParams['action'] = $tab[2];
                            } else if ($tab[2] === 'modifier') {
                                $routeAndParams['action'] = $tab[2];
                            }
                        }

                    } else if ($tab[1] === 'articles') {
                        $routeAndParams['admin'] = $tab[1];
                        
                        if(isset($tab[2])) {
                            if ($tab[2] === 'ajouter') {
                                $routeAndParams['action'] = $tab[2];
                            } else if ($tab[2] === 'modifier') {
                                $routeAndParams['action'] = $tab[2];
                            }
                        }
                    } else if ($tab[1] === 'cantine') {
                        $routeAndParams['admin'] = $tab[1];

                        if (isset($tab[2])) {
                            if ($tab[2] === 'exporter') {
                                $routeAndParams['action'] = $tab[2];
                            } else if ($tab[2] === 'creer-annee-scolaire') {
                                $routeAndParams['action'] = $tab[2];
                            }
                        }
                    }
                }
            }

            //USER
            else if ($tab[0] === 'espace-famille') {
                $routeAndParams['route'] = $tab[0];
                $routeAndParams['user'] = $tab[1];

                if (isset($tab[2])) {
                    if ($tab[2] === 'enfants') {
                        $routeAndParams['familySpace'] = $tab[2];

                        if (isset($tab[3])) {
                            if ($tab[3] === 'ajouter') {
                                $routeAndParams['action'] = $tab[3];
                            } else if ($tab[3] === 'modifier') {
                                $routeAndParams['action'] = $tab[3];
                                $routeAndParams['child'] = intval($tab[4]);
                            } else {
                                $routeAndParams['child'] = intval($tab[3]);
                            }
                        }
                    } else if ($tab[2] === 'cantine') {
                        $routeAndParams['familySpace'] = $tab[2];

                        if (isset($tab[3])) {
                            if ($tab[3] === 'inscrire') {
                                $routeAndParams['action'] = $tab[3];
                                $routeAndParams['week'] = $tab[4];
                            } else if ($tab[3] === 'modifier') {
                                $routeAndParams['action'] = $tab[3];
                                $routeAndParams['week'] = $tab[4];
                            }
                        }
                    } else if ($tab[2] === 'modifier-parent') {
                        $routeAndParams['familySpace'] = $tab[2];
                    }
                }
            }
        }
        else {
            $routeAndParams['route'] = '';
        }
        return $routeAndParams;
    }

    public function checkRoute(string $route): void
    {
        $routeTab = $this->splitRouteAndParameters($route);
        var_dump($routeTab);

        // PUBLIC
        if ($routeTab['route'] === '') {
            $this->pageController->publicHomepage();
        } else if ($routeTab['route'] === 'mairie') {
            if ($routeTab['subRoute'] === 'conseil-municipal') {
                if ($routeTab['subSubRoute'] === 'crcm') {
                    if (isset($routeTab['councilReportSlug'])) {
                        // TODO
                    } else {
                        $this->pageController->MunicipalCouncilReports();
                    }
                } else if ($routeTab['subSubRoute'] === 'bm') {
                    if (isset($routeTab['bulletinSlug'])) {
                        // TODO
                    } else {
                        $this->pageController->MunicipalBulletins();
                    }
                } else if ($routeTab['subSubRoute'] === 'elus') {
                    $this->staticPageController->townCouncillors();
                } else if ($routeTab['subSubRoute'] === 'plu') {
                    $this->staticPageController->localUrbanisationPlan();
                } else {
                    $this->pageController->townCouncil();
                }
            } else if ($routeTab['subRoute'] === 'services-municipaux') {
                if ($routeTab['subSubRoute'] === 'recensement') {
                    $this->staticPageController->citizenCensus();
                }
                else if ($routeTab['subSubRoute'] === 'papiers-identite') {
                    $this->staticPageController->identityDocuments();
                }
                else if ($routeTab['subSubRoute'] === 'location-salle') {
                    $this->staticPageController->bookFunctionRoom();
                } else {
                    $this->staticPageController->municipalServices();
                }
            } else {
                $this->pageController->townHall();
            }
        } else if ($routeTab['route'] === 'projets') {
            if (isset($routeTab['projectSlug'])) {
                // TODO
            } else {
                $this->pageController->projects();
            }
        } else if ($routeTab['route'] === 'pratique') {
            if (isset($routeTab['postSlug'])) {
                // TODO
            } else {
                $this->pageController->everydayLife();

            }
        } else if ($routeTab['route'] === 'vivre') {
            if (isset($routeTab['postSlug'])) {
                // TODO
            } else {
                $this->pageController->reside();
            }
        } else if ($routeTab['route'] === 'decouvrir') {
            if (isset($routeTab['postSlug'])) {
                // TODO
            } else {
                $this->pageController->discover();
            }
        } else if ($routeTab['route'] === 'mentions-legales') {
            $this->staticPageController->legalNotices();
        } else if ($routeTab['route'] === 'politique-confidentialite') {
            $this->staticPageController->privacyPolicy();
        } 
        
        // AUTHENTICATION
        else if ($routeTab['route'] === 'authentification') {
            if ($routeTab['authentication'] === 'enregistrer-nouveau-compte') {
                $this->authenticationController->register();
            } else if ($routeTab['authentication'] === 'se-connecter') {
                $this->authenticationController->login();
            } else if ($routeTab['authentication'] === 'se-deconnecter') {
                $this->authenticationController->logout();
            }
        } 
        
        // ADMIN
        else if ($routeTab['route'] === 'admin') {
            if (isset($_SESSION['user_id']) && (($_SESSION['user_role'] === 'ROLE_ADMIN') || ($_SESSION['user_role'] === 'ROLE_SUPER_ADMIN'))) {
                if ($routeTab['admin'] === 'modifier-email') {
                    $this->adminController->modifyEmail();
                } else if ($routeTab['admin'] === 'ajouter-un-fichier') {
                    $this->fileController->uploadFile($_GET['file']);
                } else if ($routeTab['admin'] === 'bulletins-municipaux') {
                    $this->adminController->municipalBulletins();

                    if (isset($routeTab['bulletinSlug'])) {
                        // TODO show bulletin in pdf
                    }
                } else if ($routeTab['admin'] === 'comptes-rendus-conseils-municipaux') {
                    $this->adminController->municipalCouncilReports();

                    if (isset($routeTab['councilReportSlug'])) {
                        // TODO show councilreport in pdf
                    }
                } else if ($routeTab['admin'] === 'informations-locales') {
                    if ($routeTab['subRoute'] === 'associations') {
                        if ($routeTab['action'] === 'ajouter') {
                            $this->adminController->addAssociation();
                        } else if ($routeTab['action'] === 'modifier') {
                            $this->adminController->modifyAssociation(htmlspecialchars($_GET['associationId']));
                        } else {
                            $this->adminController->associations();
                        }
                    } else if ($routeTab['subRoute'] === 'lieux') {
                        if ($routeTab['action'] === 'ajouter') {
                            $this->adminController->addLocation();
                        } else if ($routeTab['action'] === 'modifier') {
                            $this->adminController->modifyLocation(htmlspecialchars($_GET['locationId']));
                        } else {
                            $this->adminController->locations();
                        }
                    } else if ($routeTab['subRoute'] === 'professionnels-locaux') {
                        if ($routeTab['action'] === 'ajouter') {
                            $this->adminController->addLocalProfessional();
                        } else if ($routeTab['action'] === 'modifier') {
                            $this->adminController->modifyLocalProfessional(htmlspecialchars($_GET['localProfessionalId']));
                        } else {
                            $this->adminController->localProfessionals();
                        }
                    } else {
                        $this->adminController->localInformation();
                    }
                } else if ($routeTab['admin'] === 'cantine') {
                    if ($routeTab['action'] === 'creer-annee-scolaire') {
                        $this->adminController->newCafeteriaDates();
                    } else if ($routeTab['action'] === 'exporter') {
                        $this->adminController->export();
                    } else {
                        $this->adminController->cafeteriaDates();
                    }
                } else if ($routeTab['admin'] === 'evenements') {
                    if ($routeTab['action'] === 'ajouter') {
                        $this->adminController->addEvent();
                    } else if ($routeTab['action'] === 'modifier') {
                        $this->adminController->modifyEvent(htmlspecialchars($_GET['eventId']));
                    } else {
                        $this->adminController->events();
                    }
                } else if ($routeTab['admin'] === 'articles') {
                    if ($routeTab['action'] === 'ajouter') {
                        $this->postController->addPost();
                    } else if ($routeTab['action'] === 'modifier') {
                        $this->postController->modifyPost(htmlspecialchars($_GET['postId']));
                    } else {
                        $this->postController->posts();
                    }
                } else {
                    $this->adminController->adminHomepage();
                }
            } else {
                header('Location:/projet-final/projet-mairie/authentification/se-connecter');
            }
        } 
        
        // USER
        else if ($routeTab['route'] === 'espace-famille') {
            if (isset($_SESSION['user_id']) && ($_SESSION['user_role'] === 'ROLE_USER')) {
                if ($routeTab['familySpace'] === 'enfants') {
                    if (isset($routeTab['child']) && !isset($routeTab['action'])) {
                        $this->userController->readChild($routeTab['child']);
                    } else if ($routeTab['action'] === 'modifier') {
                        $this->userController->updateChild($routeTab['child']);
                    } else if ($routeTab['action'] === 'ajouter') {
                        $this->userController->createChild();
                    } else {
                        $this->userController->readChildren($_SESSION['user_id']);
                    }
                } else if ($routeTab['familySpace'] === 'cantine') {
                    if ($routeTab['action'] === 'inscrire') {
                        $this->userController->cafeteriaEnrollment($routeTab['week']);
                    } else if ($routeTab['action'] === 'modifier') {
                        $this->userController->cafeteriaEnrollmentModify();
                    } else {
                        $this->userController->CafeteriaDates();
                    }
                } else if ($routeTab['familySpace'] === 'modifier-parent') {
                    $this->userController->updateUser();
                } else {
                    $this->userController->userHomepage();
                }
            } else {
                header('Location:/projet-final/projet-mairie/authentification/se-connecter');
            }
        } 
        
        // ERROR
        else {
            $this->pageController->error404(); //rendered on public layout, is that good or should i keep it as a echo ?
        }
    }
}

?>