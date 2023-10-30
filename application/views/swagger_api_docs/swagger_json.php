{
  "openapi": "3.0.1",
  "info": {
    "title": "Webservice iProc Wika",
    "description": "Webservice integrasi iProc Wika",
    "version": "0.1"
  },
  "servers": [
    {
      "url": "<?php echo site_url() ?>"
    }
  ],
  "tags":[
  {"name":"PMCS","description":"Integrasi dengan PMCS",
  "externalDocs":
    {"description":"Find out more",
    "url":"http://swagger.io"}
  },{"name":"SIMDIV","description":"Integrasi dengan SIMDIV",
  "externalDocs":
    {"description":"Find out more",
    "url":"http://swagger.io"}
  },
  ],
  "paths": {
    "/pmcs": {
      "post": {
        "tags":["PMCS"],
        "description": "Webservice untuk menambah dan/atau mengubah Perencanaan Pengadaan dari PMCS",
        "requestBody": {
        "description": "Request body pada contoh untuk per 1 item",
        "required":true,
          "content": {
            "application/json": {
              "schema": {
                "type": "array",
                "items": {
                  "properties": {
                    "spk_code": {
                      "type": "string"
                    },
                    "nama_proyek": {
                      "type": "string"
                    },
                    "kode_departemen": {
                      "type": "string"
                    },
                    "nama_departemen": {
                      "type": "string"
                    },
                    "kode_master_sumberdaya": {
                      "type": "string"
                    },
                    "nama_master_sumberdaya": {
                      "type": "string"
                    },
                    "kelompok_sumberdaya": {
                      "type": "string"
                    },
                    "kode_sumberdaya": {
                      "type": "string"
                    },
                    "nama_sumberdaya": {
                      "type": "string"
                    },
                    "satuan": {
                      "type": "string"
                    },
                    "volume_sumberdaya": {
                      "type": "string"
                    },
                    "periode_pengadaan": {
                      "type": "string"
                    },
                    "harga_satuan": {
                      "type": "string"
                    },
                    "total_nilai": {
                      "type": "string"
                    },
                    "kode_coa": {
                      "type": "string"
                    },
                    "nama_coa": {
                      "type": "string"
                    },
                    "mata_uang": {
                      "type": "string"
                    },
                    "user_id": {
                      "type": "string"
                    },
                    "nama_user": {
                      "type": "string"
                    },
                    "periode_locking": {
                      "type": "string"
                    },
                    "is_matgis": {
                      "type": "string"
                    }
                  }
                }
              }
            }
          }
        },
        "responses": {
          "200": {
            "description": "Success"
          },
          "502": {
            "description": "Failed"
          }
        }
      },
      "get": {
        "tags":["PMCS"],
        "description": "Untuk mengambil sisa volume item PMCS",
        "parameters": [
          {
            "name": "spk_code",
            "in": "header",
            "description": "kode SPK",
            "schema": {
              "type": "string"
            },
            "example": "H01C11"
          },
          {
            "name": "kode_departemen",
            "in": "header",
            "description": "Kode Departemen",
            "schema": {
              "type": "string"
            },
            "example": "C"
          },
          {
            "name": "kode_coa",
            "in": "header",
            "description": "Kode COA",
            "schema": {
              "type": "string"
            },
            "example": "6101111"
          },
          {
            "name": "kode_grup_katalog",
            "in": "header",
            "description": "Kode Grup Katalog",
            "schema": {
              "type": "string"
            },
            "example": "AJ9"
          },
          {
            "name": "kode_katalog",
            "in": "header",
            "description": "Kode Katalog",
            "schema": {
              "type": "string"
            },
            "example": "AJ9001"
          },
          {
            "name": "periode_pengadaan",
            "in": "header",
            "description": "Periode Pengadaan",
            "schema": {
              "type": "string"
            },
            "example": "2018-01-11"
          }
        ],
        "responses": {
          "200": {
            "description": "Success"
          },
          "502": {
            "description": "Failed"
          }
        }
      }
    },
    "/simdiv": {
        "post": {
          "tags":["SIMDIV"],
          "description": "Webservice untuk menambah dan/atau mengubah Perencanaan Pengadaan dari SIMDIV",
          "requestBody": {
          "description": "Request body pada contoh untuk per 1 item",
          "required":true,
            "content": {
              "application/json": {
                "schema": {
                  "type": "array",
                  "items": {
                    "properties": {
                      "kode_departemen": {
                          "type": "string"
                        },
                        "nama_departemen": {
                          "type": "string"
                        },
                        "kode_uker": {
                          "type": "string"
                        },
                        "nama_uker": {
                          "type": "string"
                        },
                        "kode_coa": {
                          "type": "string"
                        },
                        "nama_coa": {
                          "type": "string"
                        },
                        "mata_uang": {
                          "type": "string"
                        },
                        "nilai_coa": {
                          "type": "string"
                        },
                        "periode_perencanaan_pemakaian": {
                          "type": "string"
                        },
                        "user_id": {
                          "type": "string"
                        },
                        "nama_user": {
                          "type": "string"
                        },
                  }
                }
              }
            }
          },
          "responses": {
            "200": {
              "description": "Success"
            },
            "502": {
              "description": "Failed"
            }
          }
        }
      }
    },
  "components": {
    "securitySchemes": {
      "basic": {
        "type": "https",
        "scheme": "basic"
      }
    }
  }
}
}




