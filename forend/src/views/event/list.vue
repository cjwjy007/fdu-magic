<template>
    <div class="app-container">
        <el-collapse v-model="activeCollapseNames">
            <el-collapse-item title="添加事件" name="1">
                <el-form :model="newData" :rules='formRules' :label-position="labelPosition" ref="addForm">
                    <el-form-item label="日期" prop="date">
                        <el-input v-model="newData.date" placeholder="日期"></el-input>
                    </el-form-item>
                    <el-form-item label="事件类型" prop="type">
                        <el-input v-model="newData.type" placeholder="事件类型"></el-input>
                    </el-form-item>
                    <el-form-item label="详细描述" prop="desc">
                        <el-input v-model="newData.desc"></el-input>
                    </el-form-item>
                    <el-form-item label="备注" prop="remark">
                        <el-input type="textarea" v-model="newData.remark"></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="handleAdd('addForm')">添加</el-button>
                    </el-form-item>
                </el-form>
            </el-collapse-item>
            <el-collapse-item title="事件列表" name="2">
                <el-table
                        :data="magicData"
                        style="width: 100%">
                    <el-table-column type="expand">
                        <template scope="props">
                            <pre>备注：{{ props.row.remark }}</pre>
                        </template>
                    </el-table-column>
                    <el-table-column
                            label="日期"
                            prop="date">
                    </el-table-column>
                    <el-table-column
                            label="事件类型"
                            prop="type">
                    </el-table-column>
                    <el-table-column
                            label="详细描述"
                            prop="decs">
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
            <el-form :model="editData" :rules='formRules' :label-position="labelPosition" ref="editForm">
                <el-form-item label="日期" prop="date">
                    <el-input v-model="newData.date" placeholder="日期"></el-input>
                </el-form-item>
                <el-form-item label="事件类型" prop="type">
                    <el-input v-model="newData.type" placeholder="事件类型"></el-input>
                </el-form-item>
                <el-form-item label="详细描述" prop="desc">
                    <el-input v-model="newData.desc"></el-input>
                </el-form-item>
                <el-form-item label="备注" prop="remark">
                    <el-input type="textarea" v-model="newData.remark"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="confirmEdit('editForm')">确认编辑</el-button>
                </el-form-item>
            </el-form>
        </el-dialog>
    </div>

</template>

<script>
    import {getMagicEventList, addMagicEventInfo, editMagicEventInfo, deleteMagicEventInfo} from '../../api/api.js'
    import ElDialog from "../../../node_modules/element-ui/packages/dialog/src/component.vue";

    export default {
        components: {ElDialog},
        data() {
            return {
                labelPosition: 'top',
                activeCollapseNames: ['2'],
                isEditDialogShow: false,
                newData: {
                    date: '',
                    type: '',
                    desc: '',
                    remark: ''
                },
                editData: {
                    date: '',
                    type: '',
                    desc: '',
                    remark: ''
                },
                magicData: [],
                formRules: {
                    date: [
                        {required: true, message: '请输入日期', trigger: 'blur'}
                    ],
                    type: [
                        {required: true, message: '请输入事件类型', trigger: 'blur'}
                    ],
                    desc: [
                        {required: true, message: '请输入事件详情', trigger: 'blur'}
                    ]
                }
            }
        },
        methods: {
            initList() {
                this.magicData = [];
                getMagicEventList().then((res) => {
                    res.data.forEach((item) => {
                        this.magicData.push({
                            id: item.event_id,
                            type: item.event_type,
                            desc: item.event_decs,
                            remark: item.event_remark,
                            date: item.event_date
                        })
                    })
                })
            },
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
                            addMagicEventInfo(this.newData).then(() => {
                                    this.$message({
                                        type: 'success',
                                        message: '添加成功!'
                                    });
                                    this.newData = {
                                        date: '',
                                        type: '',
                                        desc: '',
                                        remark: ''
                                    };
                                    this.initList();
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
                this.editData.id = row.id;
                this.editData.desc = row.desc;
                this.editData.type = row.type;
                this.editData.date = row.date;
                this.editData.remark = row.remark;
                this.isEditDialogShow = true;
            },
            confirmEdit(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.$confirm('是否确认编辑内容?', '提示', {
                            confirmButtonText: '确定',
                            cancelButtonText: '取消',
                            type: 'warning'
                        }).then(() => {
                            editMagicEventInfo(this.editData).then(() => {
                                this.$message({
                                    type: 'success',
                                    message: '编辑成功!'
                                });
                                this.initList();
                                this.isEditDialogShow = false;
                            }).catch(() => {
                                this.$message.error('编辑失败!');
                            });
                        }).catch(() => {
                            this.$message({
                                type: 'info',
                                message: '已取消编辑'
                            });
                            this.isEditDialogShow = false;
                        });
                    } else {
                        return false;
                    }
                })
            },
            handleDelete(index, row) {
                this.$confirm('此操作将永久删除记录, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    deleteMagicEventInfo(row.id).then(() => {
                        this.magicData.splice(index, 1);
                        this.$message({
                            type: 'success',
                            message: '删除成功!'
                        });
                        this.initList();
                    }).catch(() => {
                        this.$message.error('删除失败!');
                    })
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
            this.initList();
        }
    }

</script>