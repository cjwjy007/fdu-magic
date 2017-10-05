<template>
    <div class="app-container">
        <el-collapse v-model="activeCollapseNames">
            <el-collapse-item title="添加视频" name="1">
                <el-form :model="newData" :rule='formRules' :label-position="labelPosition" ref="addForm">
                    <el-form-item label="魔术名" prop="name">
                        <el-input v-model="newData.name" placeholder="魔术名" required></el-input>
                    </el-form-item>
                    <el-form-item label="链接" prop="link">
                        <el-input v-model="newData.link" placeholder="链接"></el-input>
                    </el-form-item>
                    <el-form-item label="类别" prop="type">
                        <el-select v-model="newData.type" placeholder="类别">
                            <el-option label="纸牌" value="纸牌"></el-option>
                            <el-option label="道具" value="道具"></el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item label="评分" prop="star">
                        <el-rate
                                v-model="newData.star"
                                :allow-half="true"
                                :colors="['#99A9BF', '#F7BA2A', '#FF9900']">
                        </el-rate>
                    </el-form-item>
                    <el-form-item label="描述" prop="desc">
                        <el-input type="textarea" v-model="newData.desc"></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="handleAdd('addForm')">添加</el-button>
                    </el-form-item>
                </el-form>
            </el-collapse-item>
            <el-collapse-item title="视频列表" name="2">
                <el-table
                        :data="magicData"
                        style="width: 100%">
                    <el-table-column type="expand">
                        <template scope="props">
                            <span>描述：{{ props.row.desc }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column
                            label="魔术名"
                            prop="name">
                    </el-table-column>
                    <el-table-column
                            label="网盘地址"
                            prop="link">
                    </el-table-column>
                    <el-table-column label="评分">
                        <template scope="scope">
                            <el-rate
                                    v-model="scope.row.star"
                                    disabled
                                    show-text
                                    :colors="['#99A9BF', '#F7BA2A', '#FF9900']"
                                    text-color="#ff9900"
                                    text-template="{value}">
                            </el-rate>
                        </template>
                    </el-table-column>
                    <el-table-column
                            prop="type"
                            label="类别"
                            width="100"
                            :filters="typeFilter"
                            :filter-method="filterType"
                            filter-placement="bottom-end">
                        <template scope="scope">
                            <el-tag
                                    :type="scope.row.type === '纸牌' ? 'primary' : 'success'"
                                    close-transition>{{scope.row.type}}
                            </el-tag>
                        </template>
                    </el-table-column>

                    <el-table-column label="操作">
                        <template scope="scope">
                            <el-button
                                    size="small"
                                    @click="handleEdit(scope.$index, scope.row)">编辑
                            </el-button>
                            <el-button
                                    size="small"
                                    type="danger"
                                    @click="handleDelete(scope.$index, scope.row)">删除
                            </el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </el-collapse-item>
        </el-collapse>
        <el-dialog title="编辑" :visible.sync="isEditDialogShow" size="small">
            <el-form :model="editData" :rule='formRules' :label-position="labelPosition" ref="editForm">
                <el-form-item label="魔术名" prop="name">
                    <el-input v-model="editData.name" placeholder="魔术名" required></el-input>
                </el-form-item>
                <el-form-item label="链接" prop="link">
                    <el-input v-model="editData.link" placeholder="链接"></el-input>
                </el-form-item>
                <el-form-item label="类别" prop="type">
                    <el-select v-model="editData.type" placeholder="类别">
                        <el-option label="纸牌" value="纸牌"></el-option>
                        <el-option label="道具" value="道具"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="评分" prop="star">
                    <el-rate
                            v-model="editData.star"
                            :allow-half="true"
                            :colors="['#99A9BF', '#F7BA2A', '#FF9900']">
                    </el-rate>
                </el-form-item>
                <el-form-item label="描述" prop="desc">
                    <el-input type="textarea" v-model="editData.desc"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="confirmEdit('editForm')">添加</el-button>
                </el-form-item>
            </el-form>
        </el-dialog>
    </div>

</template>

<script>
    import {getMagicVideoList, addMagicVideoInfo, editMagicVideoInfo, deleteMagicVideoInfo} from '../../api/api.js'
    import ElDialog from "../../../node_modules/element-ui/packages/dialog/src/component.vue";

    export default {
        components: {ElDialog},
        data() {
            return {
                labelPosition: 'top',
                activeCollapseNames: ['2'],
                isEditDialogShow: false,
                newData: {
                    id: '',
                    name: '',
                    desc: '',
                    type: '',
                    link: '',
                    star: 0
                },
                editData: {
                    id: '',
                    name: '',
                    desc: '',
                    type: '',
                    link: '',
                    star: 0
                },
                typeFilter: [{text: '纸牌', value: '纸牌'}, {text: '道具', value: '道具'}],
                magicData: [{
                    name: '1874 2015 墨菲讲座 At the Table Live Lecture starring Jay Sankey',
                    desc: '魔术在第7分钟，纯手法',
                    type: '纸牌',
                    link: 'www.baidu.com',
                    star: 5
                }, {
                    name: '1874 2015 墨菲讲座 At the Table Live Lecture starring Jay Sankey',
                    desc: '魔术在第7分钟，纯手法',
                    type: '纸牌',
                    link: 'www.baidu.com',
                    star: 4
                }, {
                    name: '1874 2015 墨菲讲座 At the Table Live Lecture starring Jay Sankey',
                    desc: '魔术在第7分钟，纯手法',
                    type: '道具',
                    link: 'www.baidu.com',
                    star: 3
                }],
                formRules: {
                    name: [
                        {required: true, message: '请输入魔术名', trigger: 'blur'},
                    ],
                    type: [
                        {required: true, message: '请选择魔术类型', trigger: 'blur'},
                    ],
                }
            }
        },
        methods: {
            handleAdd(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.$msgbox({
                            title: '消息',
                            message: this.$createElement('p', null, [
                                this.$createElement('span', null, `确认添加 ${this.newData.name}?`),
                            ]),
                            showCancelButton: true,
                            confirmButtonText: '确定',
                            cancelButtonText: '取消',
                        }).then(action => {
                            addMagicVideoInfo({'data': this.addData}).then(() => {
                                    this.$message({
                                        type: 'success',
                                        message: '添加成功!'
                                    });
                                }
                            ).catch(() => {
                                this.$message.error('添加失败!');
                            });
                        });
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            handleEdit(index, row) {
                this.editData.name = row.name;
                this.editData.desc = row.desc;
                this.editData.type = row.type;
                this.editData.link = row.link;
                this.editData.star = row.star;
                this.isEditDialogShow = true;
            },
            confirmEdit() {
                this.$confirm('是否确认编辑内容?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    console.log(index, row);
                    editMagicVideoInfo({'data': this.editData}).then(() => {
                        this.$message({
                            type: 'success',
                            message: '编辑成功!'
                        });
                    }).catch(() => {
                        this.$message.error('编辑失败!');
                    });
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消编辑'
                    });
                });
            },
            handleDelete(index, row) {
                this.$confirm('此操作将永久删除记录, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    deleteMagicVideoInfo({'data': row.id});
                    this.magicData.splice(index, 1);
                    this.$message({
                        type: 'success',
                        message: '删除成功!'
                    });
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消删除'
                    });
                });
            },
            filterType(value, row) {
                return row.type === value;
            }
        },
        mounted() {
            getMagicVideoList();
        }
    }

</script>